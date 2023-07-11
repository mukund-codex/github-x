<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\DeleteProfileRequest;
use App\Http\Requests\Profile\UpdateProfilePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user(),]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            $request->user()->sendEmailVerificationNotification();
            $request->user()->save();
            Auth::logout();
            return Redirect::route('admin.login')
                ->withErrors(['email' => __('Check your inbox and verify e-mail')]);
        }

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(UpdateProfilePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function destroy(DeleteProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to(route('admin.login'));
    }
}
