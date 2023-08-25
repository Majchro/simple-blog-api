<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class PostRepository extends Repository
{
    const POSTS_PER_PAGE = 10;

    public function __construct(private AttachmentRepository $attachment_repository)
    {
        $model = app()->make(Post::class);
        parent::__construct($model);
    }

    public function upsert(User $user, string $title, string $content, ?array $attachments = [], ?int $id = null): Post
    {
        $post = $user->posts()->updateOrCreate([
            'id' => $id,
        ], [
            'title' => $title,
            'content' => $content,
        ]);
        if (! is_null($attachments)) {
            foreach ($attachments as $attachment) {
                $this->attachment_repository
                    ->create($user, $attachment)
                    ->connection()
                    ->associate($post)
                    ->save();
            }
        }

        return $post;
    }

    public function getPaginated(): Paginator
    {
        return Post::with(['attachments'])
            ->simplePaginate(self::POSTS_PER_PAGE);
    }
}
