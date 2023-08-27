<?php

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;

beforeEach(function () {
    $admin_user = User::factory()->create([
        'role' => UserRole::Admin,
    ]);
    User::factory()->count(30)->create();
    $this->user = User::latest('id')->first();
    $this->actingAs($admin_user);
});

test('[GET] index', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('getPaginated')->andReturn(Post::simplePaginate());
    });

    $this->getJson(route('editor.users.index'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'data',
                'per_page',
            ]
        ]);
});

test('[POST] store', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('upsert');
    });

    $this->postJson(route('editor.users.store'), [
        'name' => fake()->firstName(),
        'email' => fake()->safeEmail(),
        'password' => 'zaq1@WSX',
        'role' => UserRole::Admin,
    ])
        ->assertStatus(201);
});

test('[GET] show', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->user);
    });

    $this->getJson(route('editor.users.show', $this->user->id))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
            ]
        ]);
});

test('[PUT] update', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->user);
        $mock->shouldReceive('upsert');
    });

    $this->putJson(route('editor.users.update', $this->user->id), [
        'name' => fake()->firstName(),
        'email' => fake()->safeEmail(),
        'password' => 'zaq1@WSX'
    ])
        ->assertStatus(200);
});

test('[DELETE] destroy', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->user);
        $mock->shouldReceive('delete')->andReturn(1);
    });

    $this->deleteJson(route('editor.users.destroy', $this->user->id))
        ->assertStatus(200);
});

test('[PUT] changeRole', function () {
    $this->mock(UserRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->user);
        $mock->shouldReceive('changeRole');
    });

    $this->putJson(route('editor.users.change-role', $this->user->id), [
        'role' => UserRole::Subscriber,
    ])
        ->assertStatus(200);
});
