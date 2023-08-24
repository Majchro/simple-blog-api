<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterUserController extends Controller
{
    public function __construct(private UserRepository $user_repository)
    {}

    public function store(RegisterRequest $request): JsonResponse
    {
        $this->user_repository->create(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ], Response::HTTP_CREATED);
    }
}
