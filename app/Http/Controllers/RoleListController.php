<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

class RoleListController extends Controller
{
    public function __invoke()
    {
        $roles = Role::all();
        return view('role.list', ['roles' => $roles]);
    }

}
