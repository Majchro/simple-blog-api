<?php

declare(strict_types=1);

use App\Models\Attachment;
use App\Models\User;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->attachment_repository = new AttachmentRepository(app()->make(Attachment::class));
});

it('will create file', function () {
    Storage::fake(env('FILESYSTEM_DISK'));
    $attachment = $this->attachment_repository->create(
        $this->user,
        UploadedFile::fake()->image('photo1.jpg')
    );

    Storage::disk(env('FILESYSTEM_DISK'))->assertExists($attachment->path);
});
