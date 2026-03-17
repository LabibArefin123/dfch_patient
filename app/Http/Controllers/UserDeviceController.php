<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDevice;
use App\Models\User;

class UserDeviceController extends Controller
{
    /**
     * Display all user devices
     */
    public function index()
    {
        $devices = UserDevice::with('user')->latest()->paginate(20);

        return view('backend.setting_management.user_devices.index', compact('devices'));
    }

    /**
     * Show single device
     */
    public function show($id)
    {
        $device = UserDevice::with('user')->findOrFail($id);

        return view('backend.setting_management.user_devices.show', compact('device'));
    }

    /**
     * Ban device
     */
    public function ban($id)
    {
        $device = UserDevice::findOrFail($id);
        $device->update(['is_banned' => true]);

        return back()->with('success', 'Device banned successfully.');
    }

    /**
     * Unban device
     */
    public function unban($id)
    {
        $device = UserDevice::findOrFail($id);
        $device->update(['is_banned' => false]);

        return back()->with('success', 'Device unbanned successfully.');
    }

    /**
     * Delete device
     */
    public function destroy($id)
    {
        $device = UserDevice::findOrFail($id);
        $device->delete();

        return back()->with('success', 'Device removed.');
    }
}
