<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        /* =========================
       FILTERS
    ========================== */

        if ($request->filled('user')) {
            $query->where('causer_id', $request->user);
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        $activities = $query->paginate(25);

        // 🔥 FORMAT PROPERTIES HERE
        $activities->getCollection()->transform(function ($activity) {
            $props = json_encode($activity->properties);

            $activity->short_properties = Str::words($props, 5, '...');
            $activity->full_properties  = $props;

            return $activity;
        });

        return view('backend.activity_logs.index', compact('activities'));
    }
}
