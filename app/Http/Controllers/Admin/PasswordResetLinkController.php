<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\ValueObjects\Admin\NotificationVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{

    public function create(): View
    {
        return view('forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect(route('admin.login'))->with('notification', new NotificationVO(
                    NotificationEnum::SUCCESS,
                    __('Success!'),
                    __($status)
                )
            )
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

}
