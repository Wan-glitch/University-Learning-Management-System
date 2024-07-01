<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Roles;
use App\Models\PermParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:Read Role');
    // }

    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::with('permissions')->get();
        $rlist = Roles::all();

        $rolesWithUserCounts = [];
        foreach ($rlist as $role) {
            $role->userCount = $role->users()->count();
            $rolesWithUserCounts[] = $role;
        }
        return view('admin.role.index', compact('roles', 'rolesWithUserCounts','rlist', 'users'));
    }

    public function create()
    {
        $permParents = PermParent::get();
        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions', 'permParents',));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'Description' => 'nullable|string|max:100',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'Description' => $request->Description,
            'created_by' => Auth::id(),
        ]);

        if ($request->has('permissions')) {
            // Fetch the permission names by their IDs
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permParents = PermParent::with('permissions')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        $roleHasPerm = DB::table('role_has_permissions')->where('role_id', $role->id)->get();

        return view('admin.role.edit', compact('role', 'permissions', 'permParents', 'roleHasPerm'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
