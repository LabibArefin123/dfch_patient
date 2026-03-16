<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannedDevice;
use App\Models\User;

class BannedDeviceController extends Controller
{
    /**
     * Display banned devices list
     */
    public function index()
    {
        $devices = BannedDevice::latest()->paginate(20);

        return view('backend.setting_management.banned_devices.index', compact('devices'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        return view('backend.setting_management.banned_devices.create', compact('users'));
    }

    /**
     * Store new banned device
     */
    public function store(Request $request)
    {
        $request->validate([
            'ip_address'  => 'required|ip|unique:banned_devices,ip_address',
            'device_name' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:255',
            'reason'      => 'nullable|string|max:500',
            'user_id'     => 'nullable|exists:users,id'
        ]);

        BannedDevice::create([
            'ip_address'  => $request->ip_address,
            'device_name' => $request->device_name,
            'device_type' => $request->device_type,
            'reason'      => $request->reason,
            'user_id'     => $request->user_id,
        ]);

        return redirect()->route('banned_devices.index')
            ->with('success', 'Device banned successfully.');
    }

    /**
     * Show single banned device
     */
    public function show($id)
    {
        $device = BannedDevice::findOrFail($id);

        return view('backend.setting_management.banned_devices.show', compact('device'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $device = BannedDevice::findOrFail($id);
        $users  = User::pluck('name', 'id');

        return view('backend.setting_management.banned_devices.edit', compact('device', 'users'));
    }

    /**
     * Update banned device
     */
    public function update(Request $request, $id)
    {
        $device = BannedDevice::findOrFail($id);

        $request->validate([
            'ip_address'  => 'required|ip|unique:banned_devices,ip_address,' . $device->id,
            'device_name' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:255',
            'reason'      => 'nullable|string|max:500',
            'user_id'     => 'nullable|exists:users,id'
        ]);

        $device->update([
            'ip_address'  => $request->ip_address,
            'device_name' => $request->device_name,
            'device_type' => $request->device_type,
            'reason'      => $request->reason,
            'user_id'     => $request->user_id,
        ]);

        return redirect()->route('banned_devices.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Delete banned device
     */
    public function destroy($id)
    {
        $device = BannedDevice::findOrFail($id);

        $device->delete();

        return redirect()->route('banned_devices.index')
            ->with('success', 'Device removed from banned list.');
    }
}
