<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\NewPasswordRequest;
use App\Repositories\AuthenticationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NewPasswordController extends Controller
{
    public function __construct(private AuthenticationRepository $authentication_repository)
    {}

    public function update(NewPasswordRequest $request): JsonResponse
    {
        $this->authentication_repository->resetPassword(
            $request->get('token'),
            $request->get('email'),
            $request->get('password'),
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ], Response::HTTP_OK);
    }
}
