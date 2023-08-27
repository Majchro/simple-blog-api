<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->sharedPolicy($user);
    }

    public function update(User $user, Post $post): bool
    {
        return $this->sharedPolicy($user);
    }

    public function delete(User $user, Post $post): bool
    {
        return $this->sharedPolicy($user);
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    private function sharedPolicy(User $user): bool
    {
        return in_array($user->role, [
            UserRole::Editor,
            UserRole::Admin,
        ]);
    }
}
