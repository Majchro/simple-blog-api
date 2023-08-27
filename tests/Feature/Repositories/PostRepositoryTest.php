<?php

declare(strict_types=1);

use App\Models\Attachment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\AttachmentRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()
        ->hasPosts(30)
        ->create();
    $mock = $this->mock(AttachmentRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('create')->andReturn(Attachment::factory()->create([
            'user_id' => $this->user->id,
        ]));
    });
    $this->post_repository = new PostRepository($mock);
});

describe('upsert', function () {
    it('will create post without attachments', function () {
        $post = $this->post_repository->upsert(
            user: $this->user,
            title: 'New post',
            content: fake()->paragraph(5),
        );

        expect($post->title)
            ->toBe('New post');
    });

    it('will assign attachment to post', function () {
        $post = $this->post_repository->upsert(
            user: $this->user,
            title: 'New post',
            content: fake()->paragraph(5),
            attachments: [UploadedFile::fake()->image('test.jpg')],
        );

        expect($post->attachments()->count())
            ->toBe(1);
    });

    it('will update post', function () {
        $post = Post::first();
        $this->post_repository->upsert(
            user: $this->user,
            title: 'Updated post',
            content: fake()->paragraph(5),
            id: $post->id,
        );

        expect($post->fresh()->title)
            ->toBe('Updated post');
    });
});

it('will get paginated posts', function () {
    $data = $this->post_repository->getPaginated();

    expect($data->items())
        ->toHaveCount(10);
});
