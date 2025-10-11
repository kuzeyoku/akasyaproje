<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasModule;
use App\Traits\HasTranslations;
use Illuminate\Support\Str;

class Page extends BaseModel
{
    use HasModule;
    use HasTranslations;

    protected $translationModel = PageTranslate::class;

    protected $translationForeignKey = 'page_id';

    protected $module = ModuleEnum::Page;

    protected $fillable = [
        'type',
        'slug',
        'status',
        'quick_link',
    ];

    public function scopeType($query, $type)
    {
        $query->type($type);
    }

    protected $with = ['translate'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug(request('title.'.app()->getFallbackLocale()));
        });
    }
}
