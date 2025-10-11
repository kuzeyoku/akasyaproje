<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Brand;

class BrandService extends BaseService
{
    public function __construct(Brand $brand)
    {
        parent::__construct($brand, ModuleEnum::Brand);
    }
}
