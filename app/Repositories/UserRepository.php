<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\UserRole;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    const USERS_PER_PAGE = 10;

    public function __construct()
    {
        $this->model = app()->make(User::class);
    }

    public function upsert(string $name, string $email, string $password, ?UserRole $role = UserRole::Subscriber, int $id = null): User
    {
        $user = User::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        return $user;
    }

    public function changeRole(int $id, UserRole $role): void
    {
        User::where('id', $id)
            ->update(['role' => $role]);
    }

    public function getPaginated(): Paginator
    {
        return User::simplePaginate(self::USERS_PER_PAGE)
            ->through(fn (User $user) => new UserResource($user));
    }
}
