<?php

declare(strict_types=1);

use App\Models\User;
use App\Repositories\AuthenticationRepository;
use Illuminate\Support\Facades\Password;
use Mockery\MockInterface;

it('will update password for user', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);
    $this->mock(AuthenticationRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('resetPassword');
    });

    $this->putJson(route('auth.reset-password'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'zaq1@WSXcde3',
        'password_confirmation' => 'zaq1@WSXcde3',
    ])
        ->assertStatus(200);
});
