<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use App\Models\Organization;
use App\Models\OrganizationEnlistment;
use App\Models\OrganizationDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function user_profile_show()
    {
        $user = Auth::user();
        return view('backend.setting_management.user_management.profile.show', compact('user'));
    }

    public function user_profile_edit()
    {
        $user = Auth::user();
        return view('backend.setting_management.user_management.profile.edit', compact('user'));
    }

    public function user_profile_update(Request $request)
    {
        $user = Auth::user();

        // 1️⃣ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Password fields 
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6',
            'confirm_password' => 'nullable|string|same:new_password',
        ]);

        // Update User Info
        $user->fill($request->only(['name', 'username', 'email', 'phone', 'phone_2']))->save();

        // Handle password change if provided
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('confirm_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            // Update new password
            if ($request->new_password && $request->confirm_password) {
                $user->password = bcrypt($request->new_password);
                $user->save();
            }
        }

        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('images/profile_pictures');

            if (!file_exists($destination)) mkdir($destination, 0755, true);

            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            $image->move($destination, $filename);
            $user->update(['profile_picture' => 'images/profile_pictures/' . $filename]);
        }

        return redirect()->route('user_profile_show')->with('success', 'Profile updated successfully.');
    }

}
