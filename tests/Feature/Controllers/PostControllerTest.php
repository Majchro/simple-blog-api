<?php

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('[GET] index', function () {
    $this->mock(PostRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('getPaginated')->andReturn(Post::simplePaginate());
    });

    $this->getJson('/')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'data',
                'per_page',
            ]
        ]);
});
