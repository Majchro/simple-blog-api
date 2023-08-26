<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->sharedPolicy($user);
    }

    public function view(User $user, User $model): bool
    {
        return $this->sharedPolicy($user);
    }

    public function create(User $user): bool
    {
        return $this->sharedPolicy($user);
    }

    public function update(User $user, User $model): bool
    {
        return $this->sharedPolicy($user);
    }

    public function delete(User $user, User $model): bool
    {
        return $this->sharedPolicy($user);
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function sharedPolicy(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }
}
