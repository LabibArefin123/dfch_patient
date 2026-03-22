<?php

namespace App\Http\Controllers;

use App\Models\SecurityLog;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SecurityLog::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('ip_address', 'like', "%{$search}%")
                ->orWhere('url', 'like', "%{$search}%");
        }

        // Attack type filter
        if ($type = $request->get('attack_type')) {
            $query->where('attack_type', $type);
        }

        $logs = $query->latest()->paginate(20);

        return view('security_logs.index', compact('logs'));
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        SecurityLog::findOrFail($id)->delete();

        return back()->with('success', 'Log deleted successfully');
    }
}
