<?php

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create([
        'role' => UserRole::Admin,
    ]);
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $this->actingAs($this->user);
});

test('[GET] index', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('getPaginated')->andReturn(Post::simplePaginate());
    });

    $this->getJson(route('editor.posts.index'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'data',
                'per_page',
            ]
        ]);
});

test('[POST] store', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('upsert');
    });

    $this->postJson(route('editor.posts.store'), [
        'title' => 'New post',
        'content' => fake()->paragraph(2),
        'attachments' => [
            UploadedFile::fake()->image('image1.png'),
            UploadedFile::fake()->image('image2.jpg'),
        ]
    ])
        ->assertStatus(201);
});

test('[GET] show', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->post);
    });

    $this->getJson(route('editor.posts.show', $this->post->id))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'content',
            ]
        ]);
});

test('[PUT] update', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->post);
        $mock->shouldReceive('upsert');
    });

    $this->putJson(route('editor.posts.update', $this->post->id), [
        'title' => 'Updated title',
        'content' => 'Content',
    ])
        ->assertStatus(200);
});

test('[DELETE] destroy', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->post);
        $mock->shouldReceive('delete')->andReturn(1);
    });

    $this->deleteJson(route('editor.posts.destroy', $this->post->id))
        ->assertStatus(200);
});
