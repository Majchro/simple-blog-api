<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\PasswordResetRequest;
use App\Repositories\AuthenticationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PasswordResetLinkController extends Controller
{
    public function __construct(private AuthenticationRepository $authentication_repository)
    {}

    public function store(PasswordResetRequest $request): JsonResponse
    {
        $is_sent = $this->authentication_repository->sendResetLink($request->get('email'));
        if ($is_sent) {
            return response()->json([
                'status' => ApiResponseStatus::Success,
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'status' => ApiResponseStatus::Error,
        ], Response::HTTP_BAD_REQUEST);
    }
}
