<?php

namespace App\Services;

use App\Enums\ModuleEnum;
use App\Models\Blog;
use App\Models\Category;

class BlogService
{
    public function getIndexData()
    {
        $cacheKey = ModuleEnum::Blog->value.'_index_'.request()->get('page', 1);
        $blogs = CacheService::cacheQuery($cacheKey, function () {
            return Blog::active()->order()->paginate(SettingService::get('pagination', 'front', 10));
        });

        return [
            'blogs' => $blogs,
            'popularPosts' => $this->getPopularPosts(),
            'categories' => $this->getCategories(),
        ];
    }

    public function getDetailData(Blog $blog)
    {
        return [
            'blog' => $blog,
            'comments' => $blog->comments()->approved()->paginate(SettingService::get('pagination', 'front', 10)),
            'popularPosts' => $this->getPopularPosts(),
            'categories' => $this->getCategories(),
            'relatedPosts' => $this->getRelatedPosts($blog),
        ];
    }

    private function getPopularPosts()
    {
        return CacheService::cacheQuery(ModuleEnum::Blog->value.'_sidebar_popular_posts', function () {
            return Blog::active()->viewOrder()->take(5)->get();
        });
    }

    private function getRelatedPosts(Blog $blog)
    {
        return CacheService::cacheQuery(ModuleEnum::Blog->value.'_'.$blog->id.'_related_posts', function () use ($blog) {
            return Blog::active()->category($blog->category_id)->exclude($blog->id)->get();
        });
    }

    private function getCategories()
    {
        return CacheService::cacheQuery(ModuleEnum::Blog->value.'_sidebar_categories', function () {
            return Category::module(ModuleEnum::Blog)->active()->get();
        });
    }
}
