<?php

use App\Models\User;
use App\Repositories\AuthenticationRepository;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('will authenticate user', function () {
    $this->mock(AuthenticationRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('login')->andReturn($this->user);
    });

    $this->postJson(route('auth.login'), [
        'email' => $this->user->email,
        'password' => 'zaq1@WSX',
    ])
        ->assertStatus(200);
});

it('will return unauthorized when credentials are wrong', function () {
    $this->mock(AuthenticationRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('login')->andReturnNull();
    });

    $this->postJson(route('auth.login'), [
        'email' => $this->user->email,
        'password' => 'pass',
    ])
        ->assertStatus(401);
});
