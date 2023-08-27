<?php

declare(strict_types=1);

use App\Repositories\AuthenticationRepository;
use Mockery\MockInterface;

it('will send email with password reset link', function () {
    $this->mock(AuthenticationRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('sendResetLink')->andReturnTrue();
    });

    $this->postJson(route('auth.forgot-password'), [
        'email' => 'test@test.com',
    ])
        ->assertStatus(201);
});

it('will return 400 if user does not exists', function () {
    $this->mock(AuthenticationRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('sendResetLink')->andReturnFalse();
    });

    $this->postJson(route('auth.forgot-password'), [
        'email' => 'test@test.com',
    ])
        ->assertStatus(400);
});
