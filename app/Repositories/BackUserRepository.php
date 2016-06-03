<?php

namespace App\Repositories;

use App\Services\Auth\Back\Enums\UserRole;
use App\Services\Auth\Back\Enums\UserStatus;
use Illuminate\Support\Collection;

class BackUserRepository
{
    public function getAllWithRole(UserRole $role): Collection
    {
        return User::where('role', $role)->get();
    }
    
    public function getAllWithRoleAndStatus(UserRole $role, UserStatus $status): Collection
    {
        return User::where('role', $role)->where('status', $status)->get();
    }
}
