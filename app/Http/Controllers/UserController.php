<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user, 'message' => 'User created successfully'], 201);
    }

    // destroy
    public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully'], 200);
}

}


class RoleController extends Controller
{
    public function assignRole(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::findByName($request->role);

        if (!$user || !$role) {
            return response()->json(['message' => 'User or Role not found'], 404);
        }

        $user->assignRole($role);

        return response()->json(['message' => 'Role assigned successfully'], 200);
    }
}



// Assigner une permission à un rôle:
class PermissionController extends Controller
{
    public function assignPermission(Request $request)
    {
        $role = Role::findByName($request->role);
        $permission = Permission::findByName($request->permission);

        if (!$role || !$permission) {
            return response()->json(['message' => 'Role or Permission not found'], 404);
        }

        $role->givePermissionTo($permission);

        return response()->json(['message' => 'Permission assigned successfully'], 200);
    }
}


