<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('content.pages.setting_management.role_permission.roles.index', compact('roles'));
    }

    public function create()
    {
        $routes = collect(\Route::getRoutes())
            ->filter(function ($route) {
                $middlewares = $route->gatherMiddleware();

                return $route->getName() // route name thakte hobe
                    && $route->getAction('controller') // controller diye define kora hobe
                    && collect($middlewares)->contains('auth') // auth ache
                    && collect($middlewares)->contains('check_permission'); // check_permission ache
            })
            ->groupBy(function ($route) {
                return class_basename(explode('@', $route->getActionName())[0]);
            });

        return view('content.pages.setting_management.role_permission.roles.create', compact('routes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            // No need to validate permissions.* here
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        // Get assigned permissions for this role
        $rolePermissions = $role->permissions()->pluck('name')->toArray();

        // Group permissions by controller/module prefix (you can customize this logic)
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Optional: Split permission names like "user.create" or "user-edit"
            return explode('.', $permission->name)[0]; // group by first part
        });

        return view('content.pages.setting_management.role_permission.roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        // Update role name
        $role->name = $request->name;
        $role->save();

        // Handle permissions
        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role->syncPermissions($request->permissions);
        } else {
            // If no permissions sent, remove all
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index');
    }


    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return back()->with('error', 'Role not found.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }
}
