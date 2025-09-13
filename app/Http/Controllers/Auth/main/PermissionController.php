<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('content.pages.role_permission.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group' => 'nullable|string|max:255'
        ]);

        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'guard_name' => 'web',
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('content.pages.role_permission.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required|in:web,api',
        ]);

        $permission->update($request->only('name', 'guard_name'));
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        Permission::destroy($id);
        return back()->with('success', 'Permission deleted successfully.');
    }
}
