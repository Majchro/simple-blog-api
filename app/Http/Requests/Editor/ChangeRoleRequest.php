<?php

declare(strict_types=1);

namespace App\Http\Requests\Editor;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class ChangeRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'role' => ['required', new Enum(UserRole::class)],
        ];
    }
}
