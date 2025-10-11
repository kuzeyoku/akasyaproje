<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Schema;

class SettingService
{
    private const CACHE_PREFIX = 'settings';

    private const ASSET_CATEGORY = 'asset';

    public static function getAll(): Collection
    {
        if (! self::hasSettingsTable()) {
            return collect();
        }

        return CacheService::remember(self::CACHE_PREFIX, function () {
            return Setting::all();
        });
    }

    public static function get(string $category, string $key, mixed $default = null): mixed
    {
        self::validateCategory($category);
        self::validateKey($key);
        $cacheKey = self::buildCacheKey($category, $key);

        return CacheService::remember($cacheKey, function () use ($category, $key, $default) {
            $setting = self::getAll()->firstWhere(function ($setting) use ($category, $key) {
                return $setting->category === $category && $setting->key === $key;
            });

            return $setting?->value ?? $default;
        });
    }

    public static function getByCategory(string $category): array
    {
        self::validateCategory($category);
        $cacheKey = self::CACHE_PREFIX.".category.{$category}";

        return CacheService::remember($cacheKey, function () use ($category) {
            return self::getAll()->where('category', $category)->pluck('value', 'key')->toArray();
        });
    }

    public static function toArray(): array
    {
        return CacheService::remember('settings.array', function () {
            return self::getAll()->groupBy('category')->map(function ($group) {
                if ($group->first()->category === 'asset') {
                    return $group->mapWithKeys(function ($setting) {
                        return [$setting->key => $setting->getFirstMediaUrl()];
                    });
                }

                return $group->pluck('value', 'key');
            })->toArray();
        });
    }

    public static function recaptchaIsActive(): bool
    {
        return self::isActive('recaptcha');
    }

    public static function isActive(string $category): bool
    {
        self::validateCategory($category);
        $status = self::get($category, 'status', StatusEnum::Passive->value);

        return $status === StatusEnum::Active->value;
    }

    public static function hasSettingsTable(): bool
    {
        try {
            return Schema::hasTable('settings');
        } catch (\Exception $e) {
            Log::warning('Ayarlar tablosunun varlığı kontrol edilemedi.', ['error' => $e->getMessage()]);

            return false;
        }
    }

    private static function buildCacheKey(string $category, string $key): string
    {
        return self::CACHE_PREFIX.".{$category}.{$key}";
    }

    private static function validateCategory(string $category): void
    {
        if (empty(trim($category))) {
            throw new InvalidArgumentException('Kategori boş olamaz');
        }
    }

    private static function validateKey(string $key): void
    {
        if (empty(trim($key))) {
            throw new InvalidArgumentException('Anahtar boş olamaz');
        }
    }
}
