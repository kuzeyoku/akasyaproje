<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class CacheService
{
    public static function isActive(): bool
    {
        return false;
    }

    public static function time(): int
    {
        if (! self::isActive()) {
            return 0;
        }

        return env('CACHE_EXPIRE', 3600);
    }

    public static function remember(string $key, Closure $callback)
    {
        self::validateKey($key);

        $ttl = self::time();

        if ($ttl == 0) {
            return $callback();
        }

        return Cache::remember($key, $ttl, $callback);

    }

    public static function cacheQuery(string $key, callable $query)
    {
        self::validateKey($key);

        if (! self::isActive()) {
            return $query();
        }

        $localizedKey = self::buildLocalizedKey($key);

        return Cache::remember($localizedKey, self::time(), $query);
    }

    private static function validateKey(string $key): void
    {
        if (empty(trim($key))) {
            throw new InvalidArgumentException('Önbellek anahtarı boş olamaz');
        }
        if (strlen($key) > 250) {
            throw new InvalidArgumentException('Önbellek anahtarı çok uzun (maksimum 250 karakter)');
        }
    }

    public static function forget(string $key): void
    {
        self::validateKey($key);
        Cache::forget($key);
    }

    public static function clearAll(): bool
    {
        try {
            Cache::flush();

            return true;
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }

    public static function has(string $key): bool
    {
        self::validateKey($key);

        return Cache::has($key);
    }

    public static function put(string $key, mixed $value)
    {
        self::validateKey($key);
        $ttl = self::time();

        return Cache::put($key, $value, $ttl);
    }

    public static function getStats(): array
    {
        return [
            'is_active' => self::isActive(),
            'ttl' => self::time(),
            'store' => config('cache.default'),
            'prefix' => config('cache.prefix'),
        ];
    }

    public static function buildLocalizedKey(string $key): string
    {
        $locale = app()->getLocale();

        return "{$key}:{$locale}";
    }
}
