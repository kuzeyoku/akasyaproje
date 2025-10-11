<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'company',
        'position',
        'message',
        'status',
        'order',
    ];
}
