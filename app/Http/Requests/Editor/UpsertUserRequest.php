<?php

namespace App\Http\Requests\Editor;

use App\Enums\UserRole;
use App\Http\Requests\Authentication\RegisterRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpsertUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $base_rules = (new RegisterRequest)->rules();

        return array_merge($base_rules, [
            'role' => [new Enum(UserRole::class)],
            'password' => ['required', Password::defaults()],
        ]);
    }
}
