<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        return view('role-permission.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:13',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with('status', 'Data Saved Successfully');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('role-permission.user.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:5|max:13',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('status', 'Data Updated Successfully');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('status', 'Data Deleted Successfully');
    }
}
