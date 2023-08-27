<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthenticationRepository
{
    public function create(string $name, string $email, string $password): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => UserRole::Subscriber,
        ]);
        event(new Registered($user));

        return $user;
    }

    public function resetPassword(string $token, string $email, string $password): void
    {
        Password::reset([
            'token' => $token,
            'email' => $email,
            'password' => $password,
        ], function (User $user) use ($password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
            event(new PasswordReset($user));
        });
    }

    public function login(string $email, string $password): ?User
    {
        $is_authenticated = Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);

        if (! $is_authenticated) {
            return null;
        }

        session()->regenerate();

        return Auth::user();
    }

    public function sendResetLink(string $email): bool
    {
        $status = Password::sendResetLink(['email' => $email]);

        return $status === Password::RESET_LINK_SENT;
    }
}
