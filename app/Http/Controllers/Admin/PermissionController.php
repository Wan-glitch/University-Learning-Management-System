<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        $formattedPermissions = [];

        foreach ($permissions as $permission) {
            $formattedPermissions[] = [
                'id' => $permission->id,
                'text' => $permission->name,
                'parent' => null,
            ];
        }

        return response()->json($formattedPermissions);
    }
}
