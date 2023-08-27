<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ApiResponseStatus;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(private PostRepository $post_repository)
    {
    }

    public function index(): JsonResponse
    {
        $data = $this->post_repository->getPaginated();

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => $data,
        ]);
    }
}
