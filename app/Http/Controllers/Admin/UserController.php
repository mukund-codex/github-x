<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserListRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\ValueObjects\Admin\NotificationVO;
use Config;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(UserListRequest $request): View
    {

        $sort_by = $request->validated('sortBy') ?? 'id';
        $order_by = $request->validated('orderBy') ?? 'asc';

        return view('users.list', [
            'users' => UserResource::collection(
                User::orderBy($sort_by, $order_by)
                    ->paginate(10)
                    ->withQueryString()
            ),
        ]);
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all()->pluck('name', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::all()->pluck('name', 'id'),
        ]);
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user_info = $request->safe();
        $user = resolve(User::class)->create(
            [
                'first_name' => $user_info['first_name'],
                'last_name' => $user_info['last_name'] ?? null,
                'email' => $user_info['email'],
                'password' => Hash::make($user_info['password']),
            ]
        );
        $role = $user_info['role'] ?? Config::get('const.roles.user');
        $user->assignRole($role);

        event(new Registered($user));

        return Redirect::route('admin.users.index', $user)->with(
            'notification',
            new NotificationVO(
                NotificationEnum::SUCCESS,
                __('Successfully created!'),
                __('messages.user.registered')
            )
        );
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        $update = $request->safe();
        $user->update($update->except('role'));
        if (isset($update['role'])) {
            $user->syncRoles([$update['role']]);
        }

        return Redirect::route('admin.users.index', $user)->with(
            'notification',
            new NotificationVO(
                NotificationEnum::SUCCESS,
                __('Successfully updated!'),
                __('messages.user.updated')
            )
        );

    }

    /**
     * @throws \App\Exceptions\ForbiddenException
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->back()->with(
                'notification',
                new NotificationVO(
                    NotificationEnum::FAIL,
                    __('Fail!'),
                    __('You cannot remove yourself')
                )
            );
        }
        $user->delete();

        return Redirect::route('admin.users.index', $user)->with(
            'notification',
            new NotificationVO(
                NotificationEnum::SUCCESS,
                __('Successfully deleted!'),
                __('messages.user.deleted')
            )
        );
    }

}
