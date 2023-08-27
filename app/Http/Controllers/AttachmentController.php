<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AttachmentController extends Controller
{
    public function __construct(private AttachmentRepository $attachment_repository)
    {
    }

    public function show(int $id): Response|BinaryFileResponse
    {
        $attachment = $this->attachment_repository->find($id);
        if (is_null($attachment)) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        try {
            $file = Storage::path($attachment->path);

            return response()->file($file);
        } catch (FileNotFoundException) {
            return response('', Response::HTTP_NOT_FOUND);
        }
    }
}
