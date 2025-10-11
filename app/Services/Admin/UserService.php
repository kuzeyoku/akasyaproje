<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        parent::__construct($user, ModuleEnum::User);
    }
}
