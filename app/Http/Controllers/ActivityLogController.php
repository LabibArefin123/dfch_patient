<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

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

            return DataTables::of($query)

                ->addIndexColumn()

                ->addColumn('user', function ($activity) {
                    return optional($activity->causer)->name ?? 'System';
                })

                ->addColumn('log', function ($activity) {
                    return '<span class="badge badge-info">' . $activity->log_name . '</span>';
                })

                ->addColumn('model', function ($activity) {
                    return class_basename($activity->subject_type);
                })

                ->addColumn('details', function ($activity) {
                    return '
                    <button class="btn btn-info btn-sm"
                        data-toggle="modal"
                        data-target="#propertyModal"
                        data-properties=\'' . json_encode($activity->properties) . '\'
                        data-id="' . $activity->id . '">
                        View
                    </button>
                ';
                })

                ->addColumn('date', function ($activity) {
                    return '<span title="' . $activity->created_at->format('d M Y H:i') . '">' .
                        $activity->created_at->diffForHumans() .
                        '</span>';
                })

                ->rawColumns(['log', 'details', 'date']) // allow HTML

                ->make(true);
        }

        return view('backend.activity_logs.index');
    }
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->back()->with('success', 'Log deleted successfully');
    }
}
