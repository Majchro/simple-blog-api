<?php

namespace App\Http\Controllers\Editor;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Editor\UpsertPostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct(private PostRepository $post_repository)
    {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Post::class);
        $data = $this->post_repository->getPaginated();

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => $data,
        ]);
    }

    public function store(UpsertPostRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);
        $this->post_repository->upsert(
            user: $request->user(),
            title: $request->get('title'),
            content: $request->get('content'),
            attachments: $request->get('attachments'),
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->post_repository->find($id);
        $this->authorize('view', $post);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => $post,
        ]);
    }

    public function update(int $id, UpsertPostRequest $request): JsonResponse
    {
        $post = $this->post_repository->find($id);
        $this->authorize('update', $post);
        $this->post_repository->upsert(
            user: $request->user(),
            id: $id,
            title: $request->get('title'),
            content: $request->get('content'),
            attachments: $request->get('attachments'),
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $post = $this->post_repository->find($id);
        $this->authorize('delete', $post);
        $this->post_repository->delete($id);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }
}
