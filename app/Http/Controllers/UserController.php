<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::all();
        $data['roles'] = Role::all();
        return view('pages.user.index', $data);
    }

    public function store(Request $request)
    {
        try {
        $role = Role::find($request->role);
        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'password' => bcrypt($request->password),
            'jabata' => $request->jabatan
        ]);
        $user->assignRole($role);

        return redirect()->back()->with('success', 'Success Create User');
        } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Failed Create User');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) $user->delete();
        else return redirect()->back()->with('error', 'Data not Found!');
        return redirect()->back()->with('success', 'Success!');
    }
}
