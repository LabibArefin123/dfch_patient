<?php

namespace App\Http\Controllers;

use App\Models\BanUser;
use App\Models\User;
use Illuminate\Http\Request;

class BanUserController extends Controller
{
    /**
     * Display a listing of banned users.
     */
    public function index()
    {
        $bannedUsers = BanUser::with('user')
            ->where('is_banned', true)
            ->get();

        return view(
            'backend.setting_management.user_management.system_user.ban_users.index',
            compact('bannedUsers')
        );
    }

    /**
     * Show the form for creating a new ban.
     */
    public function create()
    {
        $users = User::where('is_banned', false)->get();

        return view(
            'backend.setting_management.user_management.system_user.ban_users.create',
            compact('users')
        );
    }

    /**
     * Store a newly created ban in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'ban_reason' => 'nullable|string|max:1000',
        ]);

        // Update or create ban record
        BanUser::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'is_banned' => true,
                'banned_at' => now(),
                'ban_reason' => $request->ban_reason,
            ]
        );

        // Sync quick flag on users table
        User::where('id', $request->user_id)
            ->update(['is_banned' => true]);

        return redirect()
            ->route('ban_users.index')
            ->with('success', 'User banned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BanUser $ban_user)
    {
        return view(
            'backend.setting_management.user_management.system_user.ban_user.show',
            compact('ban_user')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BanUser $ban_user)
    {
        return view(
            'backend.setting_management.user_management.system_user.ban_user.edit',
            compact('ban_user')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BanUser $ban_user)
    {
        $request->validate([
            'ban_reason' => 'nullable|string|max:1000',
        ]);

        $ban_user->update([
            'ban_reason' => $request->ban_reason,
        ]);

        return redirect()
            ->route('ban_users.index')
            ->with('success', 'Ban details updated successfully.');
    }

    /**
     * Remove the specified resource from storage (UNBAN).
     */
    public function destroy(BanUser $ban_user)
    {
        // Unban user
        $ban_user->update([
            'is_banned' => false,
            'banned_at' => null,
            'ban_reason' => null,
        ]);

        // Sync users table
        $ban_user->user->update([
            'is_banned' => false,
        ]);

        return redirect()
            ->route('ban_users.index')
            ->with('success', 'User unbanned successfully.');
    }
}
