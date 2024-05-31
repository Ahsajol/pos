<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::get();
        return view('role-permission.permission.index', ['permission' => $permission]);
    }

    public function create()
    {
        return view('role-permission.permission.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name' // Ensure the correct table name
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return Redirect('permission')->with('status', 'Data Saved Successfully');
    }

    public function edit(Permission $permission)
    {
        // return $permission;
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,' . $permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);
        return Redirect('permission')->with('status', 'Data Updated Successfully');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        $permission->delete();
        return redirect('permission')->with('status', 'Data Deleted Succesfully');
    }
}
