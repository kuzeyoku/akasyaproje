<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Category;
use App\Services\CacheService;

class CategoryService extends BaseService
{
    public function __construct(Category $category)
    {
        parent::__construct($category, ModuleEnum::Category);
    }

    public function modulesToSelectArray(): array
    {
        return [
            ModuleEnum::Blog->value => ModuleEnum::Blog->title(),
            ModuleEnum::Service->value => ModuleEnum::Service->title(),
            ModuleEnum::Product->value => ModuleEnum::Product->title(),
            ModuleEnum::Project->value => ModuleEnum::Project->title(),
        ];
    }

    public static function getModuleCategories(ModuleEnum $module, $arr = false)
    {
        $cacheKey = CacheService::buildLocalizedKey($module->value . '_categories');
        $categories = CacheService::cacheQuery($cacheKey, fn() => Category::module($module)->active()->get());
        return $arr ? $categories->pluck('title', 'id')->toArray() : $categories;
    }

    public static function toSelectArray()
    {
        $cacheKey = 'categories_toArray';

        return CacheService::cacheQuery($cacheKey, fn() => Category::all()->pluck('title', 'id')->toArray());
    }
}
