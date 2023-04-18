<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['roles'] = Role::all();

        return view('pages.role.index', $data);
    }

    public function save(Request $request)
    {
        Role::create(['name' => strtolower($request->name)]);
        return redirect()->back();
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) $role->delete();
        else return redirect()->back()->with('error', 'Data not Found!');
        return redirect()->back()->with('success', 'Success!');
    }

    public function permission($id)
    {
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['myPermissions'] = $data['role']->getAllPermissions()->pluck('name')->toarray();
        return view('pages.role.permission', $data);
    }

    public function savePermission(Request $request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);
        return redirect()->back()->with('success', 'Update Permission Success!');
        return redirect()->back();
    }
}
