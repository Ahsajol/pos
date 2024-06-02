<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create', 'store', 'addPermissionToRole', 'updatePermissionToRole']]);
        $this->middleware('permission:edit role', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $role = Role::get();
        return view('role-permission.role.index', ['role' => $role]);
    }

    public function create()
    {
        return view('role-permission.role.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name' // Ensure the correct table name
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return Redirect('role')->with('status', 'Data Saved Successfully');
    }

    public function edit(Role $role)
    {
        // return $permission;
        return view('role-permission.role.edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);
        return Redirect('role')->with('status', 'Data Updated Successfully');
    }

    public function destroy($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();
        return redirect('role')->with('status', 'Data Deleted Succesfully');
    }
    public function addPermissionToRole($roleId)
    {
        $permission = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('role-permission.role.add-permission', [
            'role' => $role,
            'permission' => $permission,
            'rolePermission' => $rolePermission,
        ]);
    }
    public function updatePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status', 'Data Updated Successfully');
    }
}
