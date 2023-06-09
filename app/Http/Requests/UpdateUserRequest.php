<?php

namespace App\Http\Requests;

use Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', Rule::in(Config::get('const.roles'))],
        ];
    }
}
