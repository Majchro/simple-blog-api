<?php

namespace App\Http\Controllers\Editor;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\JsonResponse;

class AttachmentController extends Controller
{
    public function __construct(private AttachmentRepository $attachment_repository)
    {}

    public function destroy(int $id): JsonResponse
    {
        $attachment = $this->attachment_repository->find($id);
        $this->authorize('delete', $attachment);
        $this->attachment_repository->delete($id);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }
}
