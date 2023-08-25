<?php

use App\Models\User;
use App\Repositories\Repository;

beforeEach(function () {
    $this->user = User::factory()->create();
    $model = app()->make(User::class);
    $this->repository = $this->getMockForAbstractClass(Repository::class, [$model]);
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
