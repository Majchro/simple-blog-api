<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Repositories\AuthenticationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private AuthenticationRepository $authentication_repository)
    {
    }

    public function store(LoginRequest $request): JsonResponse
    {
        $user = $this->authentication_repository->login(
            $request->get('email'),
            $request->get('password'),
        );
        if (is_null($user)) {
            return response()->json([
                'status' => ApiResponseStatus::Error,
                'message' => __('auth.failed'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
        ]);
    }
}
