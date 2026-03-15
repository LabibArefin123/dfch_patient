<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannedDevice;
use App\Models\User;

class BannedDeviceController extends Controller
{

    public function index()
    {
        $devices = BannedDevice::latest()->paginate(20);

        return view('backend.banned_devices.index', compact('devices'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');

        return view('backend.banned_devices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip',
            'device_name' => 'nullable|string',
            'device_type' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        BannedDevice::create($request->all());

        return redirect()->route('banned_devices.index')
            ->with('success', 'Device banned successfully');
    }

    public function edit($id)
    {
        $device = BannedDevice::findOrFail($id);
        $users = User::pluck('name', 'id');

        return view('backend.banned_devices.edit', compact('device', 'users'));
    }

    public function update(Request $request, $id)
    {
        $device = BannedDevice::findOrFail($id);

        $device->update($request->all());

        return redirect()->route('banned_devices.index')
            ->with('success', 'Device updated');
    }
}
