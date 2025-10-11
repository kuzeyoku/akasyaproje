<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasModule;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends BaseModel implements HasMedia
{
    use HasModule;
    use HasTranslations;
    use InteractsWithMedia;

    protected $translationModel = SliderTranslate::class;

    protected $translationForeignKey = 'slider_id';

    protected $module = ModuleEnum::Slider;

    protected $fillable = [
        'button',
        'video',
        'status',
        'order',
    ];

    protected $with = ['translate'];
}
