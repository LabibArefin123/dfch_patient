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
        $query = SecurityLog::with('user')->latest();

        // 🔍 Filter by attack type
        if ($request->attack_type) {
            $query->where('attack_type', $request->attack_type);
        }

        // 🔍 Search IP / URL
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('ip_address', 'like', '%' . $request->search . '%')
                    ->orWhere('url', 'like', '%' . $request->search . '%');
            });
        }

        $logs = $query->paginate(20);

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
