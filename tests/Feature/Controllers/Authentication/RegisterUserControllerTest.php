<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Mockery\MockInterface;

it('can create user if client is guest', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('create')->andReturn(User::make());
    });

    $this->postJson(route('auth.register'), [
        'name' => 'Testname',
        'email' => fake()->safeEmail(),
        'password' => 'zaq1@WSXcde3',
        'password_confirmation' => 'zaq1@WSXcde3',
    ])
        ->assertStatus(201);
});

it('will redirect if user is authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->postJson(route('auth.register'))
        ->assertStatus(302);
});
