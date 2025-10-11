<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Category;
use App\Models\Product;
use App\Services\CacheService;

class ProductService extends BaseService
{
    public function __construct(Product $product)
    {
        parent::__construct($product, ModuleEnum::Product);
    }

    public function getCategories(?string $locale = null): array
    {
        $locale ??= session('active_locale', app()->getFallbackLocale());

        return CacheService::remember(ModuleEnum::Product->value."_categories_{$locale}", function () use ($locale) {
            return Category::active()->module(ModuleEnum::Product)
                ->get()
                ->pluck("titles.{$locale}", 'id')
                ->toArray();
        });
    }
}
