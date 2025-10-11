<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasModule;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Popup extends BaseModel implements HasMedia
{
    use HasModule;
    use HasTranslations;
    use InteractsWithMedia;

    protected $translationModel = PopupTranslate::class;

    protected $translationForeignKey = 'popup_id';

    protected $module = ModuleEnum::Popup;

    protected $fillable = [
        'type',
        'video',
        'url',
        'setting',
        'status',
    ];

    protected $with = ['translate'];

    public function getSettingsAttribute()
    {
        return json_decode($this->setting);
    }
}
