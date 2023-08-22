<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageUploadRequest extends FormRequest
{
    public function rules(): array
    {
        $max = config('constants.user.profile_image.max');
        return [
            'file' => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:' . $max]
        ];
    }
}
