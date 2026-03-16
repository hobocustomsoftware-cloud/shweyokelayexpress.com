<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Show role permission list
     * @return view
     */
    public function index()
    {
        return view('admin.role_permissions.index');
    }

    /**
     * Assign permission
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'permissions' => 'required',
        ]);

        $role = Role::find($request->role_id);

        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.role_permissions.index')->with('success', 'Permission assigned successfully.');
    }
}
