<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SystemUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Paginate with 10 items per page
        return view('backend.setting_management.user_management.system_user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.setting_management.user_management.system_user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_2' => $request->phone_2,

            // 🔐 ENCRYPT (reversible)
            'password' => Crypt::encryptString($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()
            ->route('system_users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.setting_management.user_management.system_user.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.setting_management.user_management.system_user.edit', compact('user', 'roles'));
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
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name', // Ensure the role exists
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_2' => $request->phone_2 ?? null,
        ]);

        // Update the user's role
        $role = Role::where('name', $request->role)->first();
        $user->roles()->sync([$role->id]);

        return redirect()->route('system_users.index')
            ->with('success', 'User updated successfully updated!');
    }

    public function editPassword(User $user)
    {
        // Optional extra safety
        abort_unless(auth()->user()->hasRole('admin'), 403);

        return view('backend.system_users.change_password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update([
            // 🔐 ENCRYPT (reversible)
            'password' => Crypt::encryptString($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
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
