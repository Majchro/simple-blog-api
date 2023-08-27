<?php

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\UserRepository;

beforeEach(function () {
    User::factory()
        ->count(30)
        ->create();
    $this->user_repository = new UserRepository;
});

describe('upsert', function () {
    it('will create user', function () {
        $user = $this->user_repository->upsert(
            name: 'Name',
            email: 'email@email.com',
            password: 'zaq1@WSX',
            role: UserRole::Editor,
        );

        expect($user->email)
            ->toBe('email@email.com');
    });

    it('will update user', function () {
        $user = User::first();
        $this->user_repository->upsert(
            name: 'Name',
            email: 'new-email@email.com',
            password: 'zaq1@WSX',
            id: $user->id,
        );

        expect($user->fresh()->email)
            ->toBe('new-email@email.com');
    });
});

it('will update role', function () {
    $user = User::factory()->create(['role' => UserRole::Subscriber]);
    $this->user_repository->changeRole($user->id, UserRole::Admin);

    expect($user->fresh()->role)
        ->toBe(UserRole::Admin);
});

it('will get paginated users', function () {
    $data = $this->user_repository->getPaginated();

    expect($data->items())
        ->toHaveCount(10);
});
