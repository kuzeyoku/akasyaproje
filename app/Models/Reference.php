<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasModule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Reference extends BaseModel implements HasMedia
{
    use HasModule;
    use InteractsWithMedia;

    protected $module = ModuleEnum::Reference;

    protected $fillable = [
        'url',
        'title',
        'status',
        'order',
    ];
}
