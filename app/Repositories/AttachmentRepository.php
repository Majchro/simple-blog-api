<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository extends Repository
{
    public function __construct()
    {
        $this->model = app()->make(Attachment::class);
    }

    public static function create(User $user, UploadedFile $file): Attachment
    {
        $storage_file = Storage::disk(env('FILESYSTEM_DISK'))->put('', $file, 'public');

        return Attachment::create([
            'user_id' => $user->id,
            'filename' => $file->getClientOriginalName(),
            'content_type' => $file->getMimeType(),
            'byte_size' => $file->getSize(),
            'path' => $storage_file,
        ]);
    }
}

