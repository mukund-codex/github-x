<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetLinkRequest;
use App\ValueObjects\Admin\NotificationVO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('forgot-password');
    }

    public function store(PasswordResetLinkRequest $request): RedirectResponse
    {
        $request->validated();
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect(route('admin.login'))->with(
                'notification',
                new NotificationVO(
                    NotificationEnum::SUCCESS,
                    __('Success!'),
                    __($status)
                )
            )
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

}
