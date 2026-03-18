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

            $query = Activity::query()
                ->with('causer:id,name') // optimize
                ->select([
                    'id',
                    'log_name',
                    'description',
                    'subject_type',
                    'subject_id',
                    'causer_id',
                    'causer_type',
                    'properties',
                    'created_at'
                ])
                ->latest();

            /* =========================
        🔥 FILTERS
        ========================== */

            // 🔹 Filter by source: real vs faker/system 

            $source = $request->source ?? 'real'; // 🔥 default 
            if ($source === 'real') {
                $query->where('causer_type', 'App\Models\User');
            } elseif ($source === 'faker') {
                $query->where(function ($q) {
                    $q->whereNull('causer_type')->orWhere('causer_type', '!=', 'App\Models\User');
                });
            }

            // User filter (only real users)
            if ($request->filled('user')) {
                $query->where('causer_id', $request->user);
            }

            // Log Name
            if ($request->filled('log_name')) {
                $query->where('log_name', $request->log_name);
            }

            // Model filter
            if ($request->filled('model')) {
                $query->where('subject_type', 'like', '%' . $request->model . '%');
            }

            // Description filter
            if ($request->filled('description')) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }

            // Date range
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // USER COLUMN → show name OR ID OR SYSTEM
                ->addColumn('user', function ($activity) {
                    if ($activity->causer) {
                        return $activity->causer->name;
                    }

                    if ($activity->causer_id) {
                        return '<span class="text-warning">ID: ' . $activity->causer_id . '</span>';
                    }

                    return '<span class="text-muted">System</span>';
                })

                // LOG TYPE (colored)
                ->addColumn('log', function ($activity) {
                    $color = match ($activity->log_name) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'info'
                    };
                    return '<span class="badge badge-' . $color . '">' . ucfirst($activity->log_name) . '</span>';
                })

                ->editColumn('description', fn($a) => ucfirst($a->description))

                ->addColumn('model', fn($a) => '<span class="badge badge-secondary">' . class_basename($a->subject_type) . '</span>')

                ->addColumn('details', function ($activity) {
                    $properties = htmlspecialchars(json_encode($activity->properties), ENT_QUOTES, 'UTF-8');
                    return '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#propertyModal" data-properties="' . $properties . '" data-id="' . $activity->id . '"><i class="fas fa-eye"></i></button>';
                })

                ->addColumn('date', fn($a) => '<span title="' . $a->created_at->format('d M Y H:i:s') . '">' . $a->created_at->diffForHumans() . '</span>')

                ->rawColumns(['user', 'log', 'model', 'details', 'date'])
                ->make(true);
        }

        // 🔥 FILTER OPTIONS
        $users = \App\Models\User::pluck('name', 'id');

        $sources = [
            'real'  => 'Original User Actions',
            'faker' => 'Seeder / System Logs'
        ];

        return view('backend.activity_logs.index', compact('users', 'sources'));
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->back()->with('success', 'Log deleted successfully');
    }
}
