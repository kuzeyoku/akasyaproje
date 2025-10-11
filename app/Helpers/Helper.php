<?php

use App\Enums\StatusEnum;
use App\Services\Admin\LanguageService;
use App\Services\CacheService;
use App\Services\SettingService;

function languageList()
{
    return CacheService::remember('helper.languageList', function () {
        try {
            return LanguageService::toArray();
        } catch (\Exception $e) {
            return [];
        }
    });
}

function statusList(): array
{
    return CacheService::remember('helper.statusList', function () {
        try {
            return StatusEnum::toSelectArray();
        } catch (\Exception $e) {
            return [];
        }
    });
}

function themeView(string $folder, string $file): string
{
    if (empty($folder) || empty($file)) {
        throw new InvalidArgumentException('Klasör ve dosya boş olamaz');
    }

    $viewPath = config("template.{$folder}.view");

    if (empty($viewPath)) {
        throw new InvalidArgumentException("Klasör için şablon görünüm yolu bulunamadı: {$folder}");
    }

    return $viewPath.'.'.$file;
}

function themeAsset(string $folder, string $file): string
{
    if (empty($folder) || empty($file)) {
        throw new InvalidArgumentException('Klasör ve dosya boş olamaz');
    }

    $assetPath = config("template.{$folder}.asset");

    if (empty($assetPath)) {
        throw new InvalidArgumentException("Klasör için şablon varlık yolu bulunamadı: {$folder}");
    }

    return asset("assets/{$assetPath}/{$file}");
}

function setting(string $category, ?string $key = null, mixed $default = null): mixed
{
    if (empty($category)) {
        throw new InvalidArgumentException('Kategori boş olamaz');
    }

    try {
        if ($key === null) {
            return SettingService::getByCategory($category);
        }

        return SettingService::get($category, $key, $default);

    } catch (\Exception $e) {
        return $default;
    }
}
