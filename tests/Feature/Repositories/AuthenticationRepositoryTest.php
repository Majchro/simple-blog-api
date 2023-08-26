<?php

use App\Models\User;
use App\Repositories\AuthenticationRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

beforeEach(function () {
    $this->user_repository = new AuthenticationRepository;
});

describe('create', function () {
    it('will persist in database', function () {
        $this->user_repository->create('Testname', 'test@test.com', 'zaq1@WSX');

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
    });

    it('will dispatch event', function () {
        Event::fake();
        $this->user_repository->create('Testname', 'test@test.com', 'zaq1@WSX');

        Event::assertDispatched(Registered::class);
    });
});

describe('resetPassword', function () {
    function createUserWithToken(): array
    {
        $user = User::factory()->create();
        return [
            'user' => $user,
            'token' => Password::createToken($user),
        ];
    }

    it('will change user password in database', function () {
        $data = createUserWithToken();
        $email = $data['user']->email;
        $this->user_repository->resetPassword($data['token'], $email, 'long_password');

        expect(Auth::attempt(['email' => $email, 'password' => 'long_password']))
            ->toBeTrue();
    });

    it('will dispatch event', function () {
        Event::fake();
        $data = createUserWithToken();
        $email = $data['user']->email;
        $this->user_repository->resetPassword($data['token'], $email, 'long_password');

        Event::assertDispatched(PasswordReset::class);
    });
});

describe('login', function () {
    it('will return user', function () {
        $user = User::factory()->create();
        $user = $this->user_repository->login($user->email, 'zaq1@WSX');

        expect($user)
            ->not->toBeNull();
    });

    it('will return null if credentials are wrong', function () {
        $user = $this->user_repository->login(fake()->safeEmail(), 'zaq1@WSX');

        expect($user)
            ->toBeNull();
    });
});

describe('sendResetLink', function () {
    it('will send notification', function () {
        Notification::fake();
        $user = User::factory()->create();
        $this->user_repository->sendResetLink($user->email);

        Notification::assertSentTo($user, ResetPassword::class);
    });

    it('will not send notification if user does not exist in database', function () {
        Notification::fake();
        $this->user_repository->sendResetLink('test@test.com');

        Notification::assertNothingSent();
    });
});

