<?php

namespace App\Http\Requests\Authentication;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:15'],
            'email' => ['required', 'string', 'email', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
