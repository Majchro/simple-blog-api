<?php

use App\Enums\UserRole;
use App\Models\Attachment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\AttachmentRepository;
use Mockery\MockInterface;

beforeEach(function () {
    $user = User::factory()->create([
        'role' => UserRole::Admin,
    ]);
    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);
    $this->attachment = Attachment::factory()->create(['user_id' => $user->id]);
    $this->attachment->connection()
        ->associate($post)
        ->save();
    $this->actingAs($user);
});

test('[DELETE] destroy', function () {
    $this->mock(AttachmentRepository::class, function (MockInterface $mock) {
        $mock->shouldReceive('find')->andReturn($this->attachment);
        $mock->shouldReceive('delete')->andReturn(1);
    });

    $this->deleteJson(route('editor.attachments.destroy', $this->attachment->id))
        ->assertStatus(200);
});
