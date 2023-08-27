<?php

declare(strict_types=1);

use App\Models\User;
use App\Repositories\Repository;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->repository = $this->partialMock(Repository::class, function (MockInterface $mock) {
        $mock->model = app()->make(User::class);
    });
});

it('can find model', function () {
    $user = $this->repository->find($this->user->id);

    expect($user->email)
        ->toBe($this->user->email);
});

it('can delete model', function () {
    $this->repository->delete($this->user->id);

    expect($this->user->fresh())
        ->toBeNull();
});
