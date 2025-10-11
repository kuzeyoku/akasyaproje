<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends BaseModel implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $translationModel = CategoryTranslate::class;

    protected $translationForeignKey = 'category_id';

    protected $fillable = [
        'slug',
        'status',
        'module',
        'parent_id',
        'order',
    ];

    protected $with = ['translate'];

    public function scopeModule($query, $module)
    {
        return $query->where("module", $module);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($category) {
            $category->slug = Str::slug(request('title.' . app()->getFallbackLocale()));
        });
        self::deleting(function ($category) {
            $category->products()->update(['category_id' => 0]);
            $category->projects()->update(['category_id' => 0]);
            $category->services()->update(['category_id' => 0]);
            $category->blogs()->update(['category_id' => 0]);
            $category->subCategories()->delete();
        });
    }
}
