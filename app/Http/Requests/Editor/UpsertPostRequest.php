<?php

declare(strict_types=1);

namespace App\Http\Requests\Editor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpsertPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:3', 'max:5000'],
            'attachments' => ['array'],
            'attachments.*' => ['image', 'max:5120'],
        ];
    }
}
