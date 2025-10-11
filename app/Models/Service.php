<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasCategory;
use App\Traits\HasModule;
use App\Traits\HasTranslations;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends BaseModel implements HasMedia
{
    use HasCategory;
    use HasModule;
    use HasTranslations;
    use InteractsWithMedia;

    protected $translationModel = ServiceTranslate::class;

    protected $categoryModel = Category::class;

    protected $translationForeignKey = 'service_id';

    protected $categoryModelForeignKey = 'service_id';

    protected $module = ModuleEnum::Service;

    protected $fillable = [
        'status',
        'order',
        'slug',
        'category_id',
    ];

    protected mixed $locale;

    protected $with = ['translate', 'category'];

    public function __construct()
    {
        parent::__construct();
        $this->locale = session('locale');
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug(request('title.'.app()->getFallbackLocale()));
        });
    }
}
