<?php

namespace App\Http\Controllers\Editor;

use App\Enums\ApiResponseStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Editor\ChangeRoleRequest;
use App\Http\Requests\Editor\UpsertUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private UserRepository $user_repository)
    {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $data = $this->user_repository->getPaginated();

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => $data,
        ]);
    }

    public function store(UpsertUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $this->user_repository->upsert(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->enum('role', UserRole::class),
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->user_repository->find($id);
        $this->authorize('view', $user);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => $user,
        ]);
    }

    public function update(int $id, UpsertUserRequest $request): JsonResponse
    {
        $user = $this->user_repository->find($id);
        $this->authorize('update', $user);
        $this->user_repository->upsert(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->enum('role', UserRole::class),
            id: $id,
        );

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = $this->user_repository->find($id);
        $this->authorize('delete', $user);
        $this->user_repository->delete($id);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }

    public function changeRole(int $id, ChangeRoleRequest $request): JsonResponse
    {
        $user = $this->user_repository->find($id);
        $this->authorize('update', $user);
        $this->user_repository->changeRole($id, $request->enum('role', UserRole::class));

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }
}
