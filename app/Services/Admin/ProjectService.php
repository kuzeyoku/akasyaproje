<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Project;

class ProjectService extends BaseService
{
    public function __construct(Project $project)
    {
        parent::__construct($project, ModuleEnum::Project);
    }
}
