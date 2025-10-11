<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Blog;

class BlogService extends BaseService
{
    public function __construct(Blog $blog)
    {
        parent::__construct($blog, ModuleEnum::Blog);
    }
}
