<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function user_profile()
    {
        $user = Auth::user();
        return view('content.pages.user_management.profile_page.user_profile', compact('user'));
    }

    public function user_profile_edit()
    {
        $user = Auth::user();
        return view('content.pages.user_management.profile_page.user_profile_edit', compact('user'));
    }

    public function user_profile_update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user info
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Profile Picture Handling
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('images/profile_pictures');

            // Create folder if not exists
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Delete old picture
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            // Move new image
            $image->move($destination, $filename);

            // Save relative path to DB
            $user->profile_picture = 'images/profile_pictures/' . $filename;
        }

        $user->save();

        return redirect()->route('user_profile')->with('success', 'User updated successfully');
    }
}
