<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Slider;

class SliderService extends BaseService
{
    public function __construct(Slider $slider)
    {
        parent::__construct($slider, ModuleEnum::Slider);
    }
}
