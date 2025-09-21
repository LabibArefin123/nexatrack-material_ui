<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role as ContractsRole;

class SystemUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10); // Directly paginate the query builder
        return view('content.pages.user_management.system_user.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.pages.user_management.system_user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name', // Ensure the role exists
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign the selected role (Spatie way)
        $user->assignRole($request->role);

        // Redirect with a success message
        return redirect()
            ->route('system_users.index')
            ->with('success', '✅ User added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('content.pages.user_management.system_user.view', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('content.pages.user_management.system_user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Update user fields
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        // Update role (Spatie way)
        $user->syncRoles([$request->role]);

        return redirect()->route('system_users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('system_users.index')->with('success', 'User deleted successfully!');
    }
}
