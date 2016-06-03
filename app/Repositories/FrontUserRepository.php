<?php

namespace App\Repositories;

use App\Services\Auth\Front\Enums\UserRole;
use App\Services\Auth\Front\Enums\UserStatus;
use App\Services\Auth\Front\User;
use Illuminate\Support\Collection;

class FrontUserRepository
{
    public function getAllWithRole(UserRole $role): Collection
    {
        User::where('role', $role)->get();
    }

    public function getAllWithRoleAndStatus(UserRole $role, UserStatus $status): Collection
    {
        return User::where('role', $role)->where('status', $status)->get();
    }
}
