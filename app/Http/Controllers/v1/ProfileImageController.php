<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileImageUploadRequest;
use App\Services\UserService;
use App\Traits\ActivityLog;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProfileImageController extends Controller
{
    use HttpResponse;
    use ActivityLog;

    public function store(ProfileImageUploadRequest $request): JsonResponse
    {
        try {
            $service = new UserService();
            $image = $request->file('file');
            $user = Auth::user();
            $response = $service->upsertUserImage($user, $image);

            return $this->response(
                $response,
                __('messages.profile.profile_image_upload_success')
            );
        } catch (Throwable $throwable) {
            $user = Auth::user();
            $this->activity('Upload profile image failed', $user, $user, ['message' => $throwable->getMessage()]);

            return $this->response([], __('messages.profile.profile_image_upload_fail'), 500);
        }
    }

    public function destroy()
    {
        try {
            $user = Auth::user();
            $service = new UserService();
            $service->deleteUserImage($user);

            return $this->response(message: __('messages.profile.profile_image_delete_success'));
        } catch (Throwable $throwable) {
            $user = Auth::user();
            $this->activity('Delete profile image failed', $user, $user, ['message' => $throwable->getMessage()]);

            return $this->response([], __('messages.profile.profile_image_delete_fail'), 500);
        }
    }
}
