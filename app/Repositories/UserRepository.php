<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    const USERS_PER_PAGE = 10;

    public function __construct()
    {
        $model = app()->make(User::class);
        parent::__construct($model);
    }

    public function upsert(string $name, string $email, string $password, ?UserRole $role = UserRole::Subscriber, ?int $id = null): User
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

    public function getPaginated(): Paginator
    {
        return User::simplePaginate(self::USERS_PER_PAGE);
    }
}
