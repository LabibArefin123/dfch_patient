<?php

namespace App\Http\Controllers;

use App\Services\Patient\PatientService;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\PatientDraft;
use Carbon\Carbon;
use Spatie\Image\Image;
use App\Models\PatientCancerPhoto;
use App\Models\PatientDocument;
use App\Models\PatientEmergency;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index(Request $request)
    {

        // Base Query with Filters
        $baseQuery = Patient::withCount('cancerPhotos')
            ->with('cancerPhotos')

            // Global Search (DataTables)
            ->when($request->filled('search.value'), function ($q) use ($request) {

                $search = trim($request->input('search.value'));

                $q->where(function ($query) use ($search) {

                    $query->where('patient_code', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%")
                        ->orWhere('patient_f_name', 'like', "%{$search}%")
                        ->orWhere('patient_m_name', 'like', "%{$search}%")

                        ->orWhere('phone_1', 'like', "%{$search}%")
                        ->orWhere('phone_2', 'like', "%{$search}%")
                        ->orWhere('phone_f_1', 'like', "%{$search}%")
                        ->orWhere('phone_m_1', 'like', "%{$search}%")

                        ->orWhere('age', 'like', "%{$search}%")
                        ->orWhere('gender', 'like', "%{$search}%")

                        ->orWhere('location_simple', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%");
                });
            })

            // Gender Filter
            ->when($request->gender, function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })

            // Refer Filter
            ->when($request->filled('is_referred'), function ($q) use ($request) {
                $q->where('is_referred', (int) $request->is_referred);
            })
            // Emergency Filter
            ->when($request->filled('is_emergency'), function ($q) use ($request) {
                $q->where('is_emergency', (int) $request->is_emergency);
            })
            // Treatment Filter
            ->when($request->filled('is_treatment'), function ($q) use ($request) {
                $q->where('is_treatment', (int) $request->is_treatment);
            })
            // Investigation Patient Filter
            ->when($request->filled('is_investigated'), function ($q) use ($request) {
                $q->where('is_investigated', (int) $request->is_investigated);
            })
            // Old Cancer Filter
            ->when($request->filled('is_old_cancer'), function ($q) use ($request) {
                if ($request->is_old_cancer == '1') {
                    $q->has('cancerPhotos');
                } else {
                    $q->doesntHave('cancerPhotos');
                }
            })

            // Location Filter
            ->when($request->location_type, function ($q) use ($request) {

                $q->where('location_type', $request->location_type);

                if ($request->filled('location_value')) {

                    if ($request->location_type == 1) {
                        $q->where('location_simple', 'like', "%{$request->location_value}%");
                    }

                    if ($request->location_type == 2) {
                        $q->where(function ($sub) use ($request) {
                            $sub->where('city', 'like', "%{$request->location_value}%")
                                ->orWhere('district', 'like', "%{$request->location_value}%");
                        });
                    }

                    if ($request->location_type == 3) {
                        $q->where('country', 'like', "%{$request->location_value}%");
                    }
                }
            })

            // Date Filters
            ->when($request->date_filter === 'today', function ($q) {
                $q->whereDate('date_of_patient_added', now());
            })

            ->when($request->date_filter === 'yesterday', function ($q) {
                $q->whereDate('date_of_patient_added', now()->subDay());
            })

            ->when($request->date_filter === 'last_7_days', function ($q) {
                $q->whereDate('date_of_patient_added', '>=', now()->subDays(7));
            })

            ->when($request->date_filter === 'last_30_days', function ($q) {
                $q->whereDate('date_of_patient_added', '>=', now()->subDays(30));
            })

            ->when($request->date_filter === 'this_month', function ($q) {
                $q->whereBetween('date_of_patient_added', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
            })

            ->when($request->date_filter === 'last_month', function ($q) {
                $q->whereBetween('date_of_patient_added', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
            })

            ->when($request->date_filter === 'this_year', function ($q) {
                $q->whereYear('date_of_patient_added', now()->year);
            })

            ->when(
                $request->date_filter === 'custom' &&
                    $request->filled(['from_date', 'to_date']),
                function ($q) use ($request) {
                    $q->whereBetween('date_of_patient_added', [
                        $request->from_date,
                        $request->to_date
                    ]);
                }
            );

        // If AJAX → return DataTable + counts
        if ($request->ajax()) {
            // Clone query for counts
            /* AGE COUNTS*/
            $childPatients = (clone $baseQuery)
                ->where('age', '<', 18)
                ->count();

            $adultPatients = (clone $baseQuery)
                ->whereBetween('age', [18, 70])
                ->count();

            $seniorPatients = (clone $baseQuery)
                ->where('age', '>', 70)
                ->count();

            /* AGE FILTER */
            switch ($request->input('age_group')) {

                case 'child':
                    $baseQuery->where('age', '<', 18);
                    break;

                case 'adult':
                    $baseQuery->whereBetween('age', [18, 70]);
                    break;

                case 'senior':
                    $baseQuery->where('age', '>', 70);
                    break;
            }


            $search = trim($request->input('search.value', ''));
            $highlight = function ($text) use ($search) {

                if (empty($search) || empty($text)) {
                    return e($text);
                }

                return preg_replace(
                    '/' . preg_quote($search, '/') . '/i',
                    '<span style="background:#fff1f2;color:#c62828;padding:1px 3px;border-radius:3px;font-weight:600;">$0</span>',
                    e($text)
                );
            };

            return DataTables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('photo', function ($p) {

                    $photo = $p->patient_photo && file_exists(public_path($p->patient_photo))
                        ? asset($p->patient_photo)
                        : asset('uploads/images/default.jpg');

                    return '
                    <div class="text-center">

                        <img src="' . $photo . '"
                            alt="' . e($p->patient_name) . '"
                            class="patient-img img-thumbnail"
                            style="
                                width:50px;
                                height:50px;
                                object-fit:contain;
                                cursor:pointer;
                                background:#fff;
                            "
                            data-bs-toggle="modal"
                            data-bs-target="#imageZoomModal"
                            data-bs-img-src="' . $photo . '">

                    </div>';
                })

                ->rawColumns(['photo'])
                ->addColumn('patient_code', function ($p) use ($highlight) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">'
                        . $highlight($p->patient_code) .
                        '</a>';
                })

                ->addColumn('name', function ($p) use ($highlight) {

                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">
                    <strong>' . $highlight($p->patient_name) . '</strong><br>

                    <small class="text-muted">
                        Father: ' . $highlight($p->patient_f_name ?? 'N/A') . '
                    </small><br>

                    <small class="text-muted">
                        Mother: ' . $highlight($p->patient_m_name ?? 'N/A') . '
                    </small>
                </a>';
                })

                ->addColumn('age', function ($p) use ($highlight) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">'
                        . $highlight($p->age) .
                        '</a>';
                })

                ->addColumn('gender', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . ucfirst($p->gender) . '</a>';
                })

                ->addColumn('phone', function ($p) use ($highlight) {

                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">'
                        . $highlight($p->phone_1 ?? 'N/A')
                        . '<br><small>Alt: '
                        . $highlight($p->phone_2 ?? 'N/A')
                        . '</small>'
                        . '<br><small>Father: '
                        . $highlight($p->phone_f_1 ?? 'N/A')
                        . '</small>'
                        . '<br><small>Mother: '
                        . $highlight($p->phone_m_1 ?? 'N/A')
                        . '</small>'
                        . '</a>';
                })

                ->addColumn('location', function ($p) use ($highlight) {

                    if ($p->location_type == 1) {
                        $loc = $highlight($p->location_simple);
                    } elseif ($p->location_type == 2) {
                        $loc = $highlight($p->city) . '<br>' . $highlight($p->district);
                    } else {
                        $loc = $highlight($p->country);
                    }

                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">'
                        . $loc .
                        '</a>';
                })


                ->addColumn('is_referred', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_referred ? 'success' : 'secondary') . '">
                            <i class="fas fa-user-md"></i>
                            ' . ($p->is_referred ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('does_old_cancer', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->cancerPhotos->isNotEmpty() ? 'danger' : 'success') . '">
                            <i class="fas ' . ($p->cancerPhotos->isNotEmpty()
                        ? 'fa-radiation'
                        : 'fa-check-circle') . '"></i>
                            ' . ($p->cancerPhotos->isNotEmpty() ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('total_cancer_photos', function ($p) {
                    $reports = $p->cancerPhotos->count();
                    $totalCancer = $p->cancerPhotos->sum('total_cancer');

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-primary">
                            Reports : ' . $reports . '
                        </span>

                        <br>

                        <span class="badge badge-danger">
                            Cancer : ' . $totalCancer . '
                        </span>
                    </a>';
                })

                ->addColumn('emergency', function ($p) {
                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_emergency ? 'danger' : 'success') . '">
                            <i class="fas ' . ($p->is_emergency
                        ? 'fa-ambulance'
                        : 'fa-check-circle') . '"></i>
                            ' . ($p->is_emergency ? 'Emergency' : 'Normal') . '
                        </span>
                    </a>';
                })

                ->addColumn('treatment', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_treatment ? 'success' : 'secondary') . '">
                            <i class="fas ' . ($p->is_treatment
                        ? 'fa-procedures'
                        : 'fa-times-circle') . '"></i>
                            ' . ($p->is_treatment ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('investigation', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_investigated ? 'info' : 'secondary') . '">
                            <i class="fas ' . ($p->is_investigated
                        ? 'fa-microscope'
                        : 'fa-times-circle') . '"></i>
                            ' . ($p->is_investigated ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('date', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' .
                        \Carbon\Carbon::parse($p->date_of_patient_added)->format('d M Y') .
                        '</a>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })

                ->addColumn('action', function ($p) {
                    $showUrl   = route('patients.show', $p->id);
                    $editUrl   = route('patients.edit', $p->id);
                    $printUrl  = route('patients.print_card', $p->id);
                    $deleteUrl = route('patients.destroy', $p->id);

                    return '
                    <a href="' . $showUrl . '" class="btn btn-primary btn-sm mr-1">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="' . $printUrl . '" target="_blank" class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-print"></i>
                    </a>

                    <div class="d-inline">
                        <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="triggerDeleteModal(\'' . $deleteUrl . '\')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';
                })

                ->rawColumns([
                    'photo',
                    'patient_code',
                    'name',
                    'age',
                    'gender',
                    'phone',
                    'location',
                    'is_referred',
                    'does_old_cancer',
                    'total_cancer_photos',
                    'emergency',
                    'treatment',
                    'investigation',
                    'date',
                    'checkbox',
                    'action'
                ])

                ->with([
                    'childPatients' => $childPatients,
                    'adultPatients' => $adultPatients,
                    'seniorPatients' => $seniorPatients,
                ])

                ->make(true);
        }

        // dd([
        //     'ajax' => $request->ajax(),
        //     'expectsJson' => $request->expectsJson(),
        //     'draw' => $request->draw,
        //     'all' => $request->all(),
        // ]);

        // Initial Load (no filters)
        $childPatients  = Patient::where('age', '<', 18)->count();
        $adultPatients  = Patient::whereBetween('age', [18, 70])->count();
        $seniorPatients = Patient::where('age', '>', 70)->count();

        return view(
            'backend.patient_management.index',
            compact('childPatients', 'adultPatients', 'seniorPatients')
        );
    }

    public function patient_referred(Request $request)
    {
        // Clean "null" string values
        foreach ($request->all() as $key => $value) {
            if ($value === 'null' || $value === '') {
                $request->merge([$key => null]);
            }
        }

        // Base Query
        $baseQuery = Patient::query()
            ->with('cancerPhotos')
            ->where('is_referred', 1)

            ->when($request->filled('gender'), function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })

            ->when($request->filled('location_type'), function ($q) use ($request) {

                $q->where('location_type', $request->location_type);

                if ($request->filled('location_value')) {

                    if ($request->location_type == 1) {

                        $q->where('location_simple', 'like', "%{$request->location_value}%");
                    } elseif ($request->location_type == 2) {

                        $q->where(function ($sub) use ($request) {
                            $sub->where('city', 'like', "%{$request->location_value}%")
                                ->orWhere('district', 'like', "%{$request->location_value}%");
                        });
                    } elseif ($request->location_type == 3) {

                        $q->where('country', 'like', "%{$request->location_value}%");
                    }
                }
            })

            ->when($request->filled('is_emergency'), function ($q) use ($request) {
                $q->where('is_emergency', (int) $request->is_emergency);
            })

            ->when($request->filled('is_treatment'), function ($q) use ($request) {
                $q->where('is_treatment', (int) $request->is_treatment);
            })

            ->when($request->filled('is_investigated'), function ($q) use ($request) {
                $q->where('is_investigated', (int) $request->is_investigated);
            })

            ->when($request->filled('is_old_cancer'), function ($q) use ($request) {
                $q->where('is_old_cancer', (int) $request->is_old_cancer);
            })

            ->when($request->filled('date_filter'), function ($q) use ($request) {

                switch ($request->date_filter) {

                    case 'today':
                        $q->whereDate('date_of_patient_added', today());
                        break;

                    case 'yesterday':
                        $q->whereDate('date_of_patient_added', today()->subDay());
                        break;

                    case 'last_7_days':
                        $q->whereBetween('date_of_patient_added', [
                            now()->subDays(6)->toDateString(),
                            now()->toDateString()
                        ]);
                        break;

                    case 'last_30_days':
                        $q->whereBetween('date_of_patient_added', [
                            now()->subDays(29)->toDateString(),
                            now()->toDateString()
                        ]);
                        break;

                    case 'this_month':
                        $q->whereBetween('date_of_patient_added', [
                            now()->startOfMonth()->toDateString(),
                            now()->endOfMonth()->toDateString()
                        ]);
                        break;

                    case 'last_month':

                        $lastMonth = now()->subMonth();

                        $q->whereMonth('date_of_patient_added', $lastMonth->month)
                            ->whereYear('date_of_patient_added', $lastMonth->year);

                        break;

                    case 'this_year':
                        $q->whereYear('date_of_patient_added', now()->year);
                        break;

                    case 'custom':

                        if ($request->filled('from_date') && $request->filled('to_date')) {

                            $q->whereBetween('date_of_patient_added', [
                                $request->from_date,
                                $request->to_date
                            ]);
                        }

                        break;
                }
            });

        // AJAX Request
        if ($request->ajax()) {

            $childPatients  = (clone $baseQuery)->where('age', '<', 18)->count();
            $adultPatients  = (clone $baseQuery)->whereBetween('age', [18, 70])->count();
            $seniorPatients = (clone $baseQuery)->where('age', '>', 70)->count();

            /* AGE FILTER*/
            switch ($request->input('age_group')) {
                case 'child':
                    $baseQuery->where('age', '<', 18);
                    break;

                case 'adult':
                    $baseQuery->whereBetween('age', [18, 70]);
                    break;

                case 'senior':
                    $baseQuery->where('age', '>', 70);
                    break;
            }

            return DataTables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('photo', function ($p) {

                    $photo = $p->patient_photo && file_exists(public_path($p->patient_photo))
                        ? asset($p->patient_photo)
                        : asset('uploads/images/default.jpg');

                    return '
                    <div class="text-center">
                        <img src="' . $photo . '" 
                            class="patient-img"
                            alt="photo">
                    </div>
                ';
                })
                ->addColumn('patient_code', fn($p) => '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $p->patient_code . '</a>')
                ->addColumn('name', fn($p) => '<a href="' . route('patients.show', $p->id) . '" class="hover-box"><strong>' . $p->patient_name . '</strong><br><small class="text-muted">Father: ' . ($p->patient_f_name ?? 'N/A') . '</small><br><small class="text-muted">Mother: ' . ($p->patient_m_name ?? 'N/A') . '</small></a>')
                ->addColumn('age', fn($p) => '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $p->age . '</a>')
                ->addColumn('gender', fn($p) => '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . ucfirst($p->gender) . '</a>')
                ->addColumn('phone', fn($p) => '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . ($p->phone_1 ?? 'N/A') . '</a>')
                ->addColumn('location', function ($p) {
                    $loc = $p->location_type == 1 ? $p->location_simple : ($p->location_type == 2 ? $p->city . '<br>' . $p->district : $p->country);
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $loc . '</a>';
                })
                ->addColumn('is_referred', fn() => '<span class="badge badge-success">Recommended</span>')
                ->addColumn('does_old_cancer', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->cancerPhotos->isNotEmpty() ? 'danger' : 'success') . '">
                            <i class="fas ' . ($p->cancerPhotos->isNotEmpty()
                        ? 'fa-radiation'
                        : 'fa-check-circle') . '"></i>
                            ' . ($p->cancerPhotos->isNotEmpty() ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('total_cancer_photos', function ($p) {
                    $reports = $p->cancerPhotos->count();
                    $totalCancer = $p->cancerPhotos->sum('total_cancer');

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-primary">
                            Reports : ' . $reports . '
                        </span>

                        <br>

                        <span class="badge badge-danger">
                            Cancer : ' . $totalCancer . '
                        </span>
                    </a>';
                })

                ->addColumn('emergency', function ($p) {
                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_emergency ? 'danger' : 'success') . '">
                            <i class="fas ' . ($p->is_emergency
                        ? 'fa-ambulance'
                        : 'fa-check-circle') . '"></i>
                            ' . ($p->is_emergency ? 'Emergency' : 'Normal') . '
                        </span>
                    </a>';
                })

                ->addColumn('treatment', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_treatment ? 'success' : 'secondary') . '">
                            <i class="fas ' . ($p->is_treatment
                        ? 'fa-procedures'
                        : 'fa-times-circle') . '"></i>
                            ' . ($p->is_treatment ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })

                ->addColumn('investigation', function ($p) {

                    return '
                    <a href="' . route('patients.show', $p) . '" class="hover-box">
                        <span class="badge badge-' . ($p->is_investigated ? 'info' : 'secondary') . '">
                            <i class="fas ' . ($p->is_investigated
                        ? 'fa-microscope'
                        : 'fa-times-circle') . '"></i>
                            ' . ($p->is_investigated ? 'Yes' : 'No') . '
                        </span>
                    </a>';
                })
                ->addColumn('date', fn($p) => \Carbon\Carbon::parse($p->date_of_patient_added)->format('d M Y'))
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })

                ->addColumn('action', function ($p) {
                    $showUrl   = route('patients.show', $p->id);
                    $editUrl   = route('patients.edit', $p->id);
                    $printUrl  = route('patients.print_card', $p->id);
                    $deleteUrl = route('patients.destroy', $p->id);

                    return '
                    <a href="' . $showUrl . '" class="btn btn-secondary btn-sm mr-1">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="' . $printUrl . '" target="_blank" class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-print"></i>
                    </a>

                    <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" 
                        onsubmit="return confirm(\'Are you sure you want to delete this patient?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';
                })

                ->rawColumns([
                    'photo',
                    'patient_code',
                    'name',
                    'age',
                    'gender',
                    'phone',
                    'location',
                    'is_referred',
                    'does_old_cancer',
                    'total_cancer_photos',
                    'emergency',
                    'treatment',
                    'investigation',
                    'checkbox',
                    'action'
                ])
                ->with([
                    'childPatients'  => $childPatients,
                    'adultPatients'  => $adultPatients,
                    'seniorPatients' => $seniorPatients,
                ])
                ->make(true);
        }

        // First Page Load
        $childPatients  = (clone $baseQuery)->where('age', '<', 18)->count();
        $adultPatients  = (clone $baseQuery)->whereBetween('age', [18, 70])->count();
        $seniorPatients = (clone $baseQuery)->where('age', '>', 70)->count();

        return view('backend.patient_management.recommend_index', compact('childPatients', 'adultPatients', 'seniorPatients'));
    }

    public function patientSummarySearch(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $search = trim($request->search);

        $query = Patient::with([
            'latestEmergency',
            'emergencies',
            'documents',
            'cancerPhotos',
        ])
            ->withCount([
                'documents',
                'cancerPhotos',
                'emergencies',
            ]);

        $query->where(function ($q) use ($search) {
            $q->where('patient_name', 'like', "%{$search}%")
                ->orWhere('patient_code', 'like', "%{$search}%")
                ->orWhere('phone_1', 'like', "%{$search}%")
                ->orWhere('phone_2', 'like', "%{$search}%")
                ->orWhere('phone_f_1', 'like', "%{$search}%")
                ->orWhere('phone_m_1', 'like', "%{$search}%");

            $lower = strtolower($search);

            /* Quick Date Keywords */
            if ($lower === 'today') {
                $q->orWhereDate('date_of_patient_added', today());
            }

            if ($lower === 'yesterday') {
                $q->orWhereDate('date_of_patient_added', today()->subDay());
            }

            if (in_array($lower, ['last 7 days', 'last7days'])) {
                $q->orWhereDate('date_of_patient_added', '>=', today()->subDays(7));
            }

            if (in_array($lower, ['last 30 days', 'last30days'])) {
                $q->orWhereDate('date_of_patient_added', '>=', today()->subDays(30));
            }

            if ($lower === 'this month') {
                $q->orWhereBetween('date_of_patient_added', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ]);
            }

            /* 15/07/2026 or 15-07-2026*/
            foreach (['d/m/Y', 'd-m-Y'] as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $search);
                    $q->orWhereDate('date_of_patient_added', $date);
                    break;
                } catch (\Exception $e) {
                }
            }

            /* 15 August 2026  */
            try {
                $date = Carbon::parse($search);
                $q->orWhereDate('date_of_patient_added', $date);
            } catch (\Exception $e) {
            }

            /*15 August (any year)*/
            if (preg_match('/^\d{1,2}\s+[a-zA-Z]+$/', $search)) {
                try {
                    $date = Carbon::parse($search . ' ' . now()->year);

                    $q->orWhereDay('date_of_patient_added', $date->day)
                        ->orWhereMonth('date_of_patient_added', $date->month);
                } catch (\Exception $e) {
                }
            }
        });

        $patients = $query
            ->orderBy('patient_name')
            ->get();

        if ($patients->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Patient not found.',
            ]);
        }

        return response()->json([
            'status' => true,
            'count' => $patients->count(),
            'patients' => $patients->map(function ($patient) {
                $patientFolder = Str::slug($patient->patient_name);

                return [
                    'id' => $patient->id,
                    'patient_code' => $patient->patient_code,
                    'patient_name' => $patient->patient_name,

                    'patient_photo' => $patient->patient_photo
                        ? asset($patient->patient_photo)
                        : asset('uploads/images/default.jpg'),

                    'age' => $patient->age,
                    'gender' => $patient->gender,
                    'phone' => $patient->phone_1,
                    'father' => $patient->patient_f_name,
                    'mother' => $patient->patient_m_name,
                    'problem' => $patient->patient_problem_description,
                    'drug' => $patient->patient_drug_description,
                    'remarks' => $patient->remarks,

                    /* Referred*/
                    'recommend' => $patient->is_referred,
                    'doctor' => $patient->referred_doctor_name,
                    'referred_note' => $patient->referred_note,

                    'document_folder' => asset("uploads/documents/{$patientFolder}/recommend_doc"),

                    /* Counts*/
                    'documents' => $patient->documents_count,
                    'cancer_reports' => $patient->cancer_photos_count,
                    'emergency_records' => $patient->emergencies_count,

                    /*Emergency  */
                    'is_emergency' => $patient->is_emergency,
                    'latest_emergency' => $patient->latestEmergency ? [
                        'id' => $patient->latestEmergency->id,
                        'is_emergency' => $patient->latestEmergency->is_emergency,
                        'reason' => $patient->latestEmergency->reason,
                        'emergency_date' => optional($patient->latestEmergency->emergency_date)
                            ->format('d F Y h:i A'),
                    ] : null,

                    /*Treatment  */
                    'is_treatment' => $patient->is_treatment,
                    'treatment_information' => $patient->treatment_information ?? [],
                    'treatment_type' => $patient->treatment_type ?? [],
                    'treatment_images' => $patient->treatment_images ?? [],

                    /* Investigation */
                    'is_investigated' => $patient->is_investigated,
                    'investigation_information' => $patient->investigation_information ?? [],
                    'investigation_images' => $patient->investigation_images ?? [],

                    /* Date */
                    'date' => optional($patient->date_of_patient_added)
                        ->format('d F Y'),
                ];
            }),
        ]);
    }

    public function patientSummaryAnimation(Patient $patient)
    {
        $patient->load([
            'documents' => function ($query) {
                $query->where('document_type', 'recommendation');
            },
            'cancerPhotos'
        ]);

        return response()->json([
            'success' => true,
            'patient' => [
                'id' => $patient->id,
                'patient_name' => $patient->patient_name,
                'is_referred' => (bool) $patient->is_referred,
                'referred_doctor_name' => $patient->referred_doctor_name,
                'referred_note' => $patient->referred_note,
                'documents' => $patient->documents
                    ->where('document_type', 'recommendation')
                    ->values()
                    ->map(function ($doc) {
                        return [
                            'id' => $doc->id,
                            'document_name' => $doc->document_name,
                            'file_path' => asset($doc->file_path),
                            'document_type' => $doc->document_type,
                        ];
                    })->values(),
            ]
        ]);
    }

    public function patientDocumentSearch(Request $request)
    {
        $request->validate(['document' => 'required|file|max:20480']);
        $hash = hash_file(
            'sha256',
            $request->file('document')->getRealPath()
        );

        $documents = PatientDocument::with([
            'patient'
        ])
            ->where('file_hash', $hash)
            ->get();

        if ($documents->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'No matching recommendation document found.'
            ]);
        }

        $patients = $documents
            ->pluck('patient')
            ->unique('id')
            ->values();

        return response()->json([
            'status' => true,
            'count' => $patients->count(),
            'patients' => $patients->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'patient_code' => $patient->patient_code,
                    'patient_name' => $patient->patient_name,
                    'patient_photo' => $patient->patient_photo
                        ? asset($patient->patient_photo)
                        : asset('uploads/images/default.jpg'),

                    'age' => $patient->age,
                    'gender' => $patient->gender,
                    'phone' => $patient->phone_1,
                    'father' => $patient->patient_f_name,
                    'mother' => $patient->patient_m_name,
                    'problem' => $patient->patient_problem_description,
                    'drug' => $patient->patient_drug_description,
                    'remarks' => $patient->remarks,
                    'recommend' => $patient->is_referred,
                    'doctor' => $patient->referred_doctor_name,
                    'referred_note' => $patient->referred_note,
                    'documents' => $patient->documents()->count(),
                    'cancer_reports' => $patient->cancerPhotos()->count(),
                    'date' => optional($patient->date_of_patient_added)->format('d F Y')
                ];
            })
        ]);
    }

    public function patientDocumentContents(Patient $patient)
    {
        $patient->load('documents');

        $documents = $patient->documents->map(function ($document) {

            $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));

            return [
                'id'        => $document->id,
                'name'      => $document->document_name,
                'path'      => asset($document->file_path),
                'extension' => $extension,
                'is_image'  => in_array($extension, [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                ]),
                'is_pdf'    => $extension === 'pdf',
            ];
        });

        return response()->json([
            'status'   => true,
            'patient'  => [
                'id'   => $patient->id,
                'name' => $patient->patient_name,
                'code' => $patient->patient_code,
            ],
            'documents' => $documents,
        ]);
    }

    public function patientPhotoSearch(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240',
        ]);

        $hash = hash_file(
            'sha256',
            $request->file('photo')->getRealPath()
        );

        $results = collect();

        /*
    |--------------------------------------------------------------------------
    | 1. Profile Photo
    |--------------------------------------------------------------------------
    */

        $profilePatients = Patient::withCount([
            'documents',
            'cancerPhotos',
        ])
            ->where('photo_hash', $hash)
            ->get();

        foreach ($profilePatients as $patient) {

            $patient->matched_image = 'Profile Photo';

            $results->push($patient);
        }

        /*
    |--------------------------------------------------------------------------
    | 2. Treatment Images
    |--------------------------------------------------------------------------
    */

        $treatmentPatients = Patient::withCount([
            'documents',
            'cancerPhotos',
        ])
            ->whereJsonContains('treatment_hashes', $hash)
            ->get();

        foreach ($treatmentPatients as $patient) {

            if (!$results->contains('id', $patient->id)) {

                $patient->matched_image = 'Treatment Image';

                $results->push($patient);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | 3. Investigation Images
    |--------------------------------------------------------------------------
    */

        $investigationPatients = Patient::withCount([
            'documents',
            'cancerPhotos',
        ])
            ->whereJsonContains('investigation_hashes', $hash)
            ->get();

        foreach ($investigationPatients as $patient) {

            if (!$results->contains('id', $patient->id)) {

                $patient->matched_image = 'Investigation Image';

                $results->push($patient);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | 4. Cancer Images
    |--------------------------------------------------------------------------
    */

        $cancerReports = PatientCancerPhoto::whereJsonContains(
            'cancer_hashes',
            $hash
        )
            ->with('patient')
            ->get();

        foreach ($cancerReports as $report) {

            if (!$report->patient) {
                continue;
            }

            $patient = Patient::withCount([
                'documents',
                'cancerPhotos',
            ])
                ->find($report->patient_id);

            if (
                $patient &&
                !$results->contains('id', $patient->id)
            ) {

                $patient->matched_image = 'Cancer Image';

                $results->push($patient);
            }
        }

        if ($results->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'No matching patient photo found.',
            ]);
        }

        return response()->json([

            'status' => true,

            'count' => $results->count(),

            'patients' => $results->map(function ($patient) {

                return [

                    'id' => $patient->id,

                    'matched_image' => $patient->matched_image,

                    'patient_code' => $patient->patient_code,

                    'patient_name' => $patient->patient_name,

                    'patient_photo' => $patient->patient_photo
                        ? asset($patient->patient_photo)
                        : asset('uploads/images/default.jpg'),

                    'age' => $patient->age,

                    'gender' => $patient->gender,

                    'phone' => $patient->phone_1,

                    'father' => $patient->patient_f_name,

                    'mother' => $patient->patient_m_name,

                    'problem' => $patient->patient_problem_description,

                    'drug' => $patient->patient_drug_description,

                    'remarks' => $patient->remarks,

                    'recommend' => $patient->is_referred,

                    'doctor' => $patient->referred_doctor_name,

                    'referred_note' => $patient->referred_note,

                    'documents' => $patient->documents_count,

                    'cancer_reports' => $patient->cancer_photos_count,

                    'date' => optional(
                        $patient->date_of_patient_added
                    )->format('d F Y'),
                ];
            })->values(),
        ]);
    }

    public function patientCancerPhotoContents(Patient $patient)
    {
        $patient->load('cancerPhotos');

        $photos = [];

        foreach ($patient->cancerPhotos as $report) {

            if (empty($report->xray_photo)) {
                continue;
            }

            foreach ($report->xray_photo as $index => $photo) {

                $photos[] = [
                    'report_id' => $report->id,
                    'photo' => asset($photo),
                    'description' => $report->xray_description[$index] ?? '',
                    'cancer_remarks' => $report->cancer_remarks,
                    'total_cancer' => $report->total_cancer,
                ];
            }
        }

        return response()->json([
            'status' => true,

            'patient' => [
                'id' => $patient->id,
                'name' => $patient->patient_name,
                'code' => $patient->patient_code,
            ],

            'photos' => $photos,
        ]);
    }

    public function getModalDetails($id)
    {
        $patient = Patient::with([
            'documents',
            'cancerPhotos',
            'latestEmergency',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'patient' => $patient,
        ]);
    }

    private function filteredPatients(Request $request)
    {
        return Patient::query()

            ->when(
                $request->gender,
                fn($q) =>
                $q->where('gender', $request->gender)
            )

            ->when(
                $request->filled('is_referred'),
                fn($q) =>
                $q->where('is_referred', (int)$request->is_referred)
            )

            ->when($request->location_type, function ($q) use ($request) {

                $q->where('location_type', $request->location_type);

                if ($request->filled('location_value')) {

                    if ($request->location_type == 1) {
                        $q->where('location_simple', 'like', "%{$request->location_value}%");
                    }

                    if ($request->location_type == 2) {
                        $q->where(function ($sub) use ($request) {
                            $sub->where('city', 'like', "%{$request->location_value}%")
                                ->orWhere('district', 'like', "%{$request->location_value}%");
                        });
                    }

                    if ($request->location_type == 3) {
                        $q->where('country', 'like', "%{$request->location_value}%");
                    }
                }
            })

            ->when(
                $request->date_filter === 'today',
                fn($q) =>
                $q->whereDate('date_of_patient_added', now())
            )

            ->when(
                $request->date_filter === 'custom' &&
                    $request->filled(['from_date', 'to_date']),
                fn($q) =>
                $q->whereBetween('date_of_patient_added', [
                    $request->from_date,
                    $request->to_date
                ])
            );
    }

    public function updateEmergency(Request $request)
    {
        $validated = $request->validate([
            'patient_ids'   => ['required', 'array', 'min:1'],
            'patient_ids.*' => ['integer', 'exists:patients,id'],
            'is_emergency'  => ['required', 'boolean'],
            'reason'        => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {

            Patient::whereIn('id', $validated['patient_ids'])
                ->update([
                    'is_emergency' => $validated['is_emergency'],
                ]);

            foreach ($validated['patient_ids'] as $patientId) {

                PatientEmergency::create([
                    'patient_id'     => $patientId,
                    'is_emergency'   => $validated['is_emergency'],
                    'reason'         => $validated['reason'],
                    'emergency_date' => now(),
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => count($validated['patient_ids']) . ' patient(s) updated successfully.',
        ]);
    }

    public function create()
    {
        return view('backend.patient_management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            /* Patient Identity*/
            'patient_name' => 'required|string|max:255',
            'patient_f_name' => 'required|string|max:255',
            'patient_m_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:100',
            'gender' => 'required|in:male,female,other',

            /* Contact*/
            'phone_1' => 'required|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'phone_f_1' => 'nullable|string|max:20',
            'phone_m_1' => 'nullable|string|max:20',

            /* Location*/
            'location_type' => 'required|in:1,2,3',

            'location_simple' => 'nullable|string',
            'house_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'passport_no' => 'nullable|string|max:100',

            /*Patient Information*/
            'patient_problem_description' => 'nullable|string',
            'patient_drug_description' => 'nullable|string',
            'remarks' => 'nullable|string',

            /* Referred    */
            'referred_doctor_name' => 'nullable|string|max:255',
            'referred_note' => 'nullable|string',

            /* Treatment */
            'treatment_information' => 'nullable|string',
            'treatment_type' => ['nullable', 'in:OPD,OT',],
            'treatment_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120',],

            /*Investigation  */
            'investigation_information' => 'nullable|string',
            'investigation_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120',],

            /* Hospital */
            'date_of_patient_added' => 'required|date',

            /* Documents*/
            'documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120',],

            /* Patient Cancer Images */
            // 'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120',],
            /* Cancer */
            'total_cancer' => 'nullable|integer|min:1',
            'xray_photo.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'xray_description' => 'nullable|string',
            'cancer_remarks' => 'nullable|string',

            /* Emergency */
            'reason' => 'nullable|string',
            'emergency_date' => 'nullable|date',
        ]);

        /* Boolean Values */
        $validated['is_referred'] = $request->boolean('is_referred');
        $validated['is_emergency'] = $request->boolean('is_emergency');
        $validated['is_old_cancer'] = $request->boolean('is_old_cancer');
        $validated['is_treatment'] = $request->boolean('is_treatment');
        $validated['is_investigated'] = $request->boolean('is_investigated');

        /* Treatment Cleanup */
        if (!$validated['is_treatment']) {
            $validated['treatment_information'] = null;
            $validated['treatment_type'] = null;
            $validated['treatment_images'] = null;
            $validated['treatment_hashes'] = null;
        }

        /* Investigation Cleanup */
        if (!$validated['is_investigated']) {
            $validated['investigation_information'] = null;
            $validated['investigation_type'] = null;
            $validated['investigation_images'] = null;
            $validated['investigation_hashes'] = null;
        }

        /* Cancer Cleanup */
        if (!$validated['is_old_cancer']) {
            $validated['total_cancer'] = null;
        }

        /* Emergency Cleanup */
        if (!$validated['is_emergency']) {
            $validated['reason'] = null;
            $validated['emergency_date'] = null;
        }

        /*Location Cleanup*/
        if ($request->location_type != 1) {
            $validated['location_simple'] = null;
        }

        if ($request->location_type != 2) {
            $validated['house_address'] = null;
            $validated['city'] = null;
            $validated['district'] = null;
            $validated['post_code'] = null;
        }

        if ($request->location_type != 3) {
            $validated['country'] = null;
            $validated['passport_no'] = null;
        }

        /*Create Patient*/
        $patient = Patient::create($validated);
        if ($validated['is_emergency']) {
            PatientEmergency::create([
                'patient_id' => $patient->id,
                'is_emergency' => true,
                'reason' => $request->reason,
                'emergency_date' => $request->emergency_date,
            ]);
        }

        /* Generate Patient Code*/
        $patient->update([
            'patient_code' => 'DFCH-' . now()->format('Y') . '-' . str_pad($patient->id, 9, '0', STR_PAD_LEFT),
        ]);

        /*Patient Folder */
        $patientFolder = Str::slug($patient->patient_name . '-' . $patient->id);

        /*Folder Paths*/
        $imagePath = public_path("uploads/patients/{$patientFolder}/image");
        $documentPath = public_path("uploads/patients/{$patientFolder}/documents");
        $treatmentPath = public_path("uploads/patients/{$patientFolder}/treatment_photos");
        $investigationPath = public_path("uploads/patients/{$patientFolder}/investigation_photos");
        $cancerPath = public_path("uploads/patients/{$patientFolder}/cancer_photos");

        /* Create Directories */
        File::ensureDirectoryExists($imagePath);
        File::ensureDirectoryExists($documentPath);
        File::ensureDirectoryExists($treatmentPath);
        File::ensureDirectoryExists($investigationPath);
        File::ensureDirectoryExists($cancerPath);

        /* Upload Cancer Images*/
        if ($validated['is_old_cancer']) {
            $xrayPhotos = [];
            $xrayHashes = [];

            if ($validated['is_old_cancer'] && $request->hasFile('xray_photo')) {

                $nextNumber = 1;

                foreach (File::files($cancerPath) as $file) {
                    if (preg_match('/^cancer_(\d+)\.webp$/', $file->getFilename(), $match)) {
                        $nextNumber = max($nextNumber, ((int)$match[1]) + 1);
                    }
                }

                foreach ($request->file('xray_photo') as $image) {

                    $filename = "cancer_{$nextNumber}.webp";

                    Image::load($image->getRealPath())
                        ->width(1800)
                        ->format('webp')
                        ->quality(75)
                        ->save($cancerPath . DIRECTORY_SEPARATOR . $filename);

                    $xrayPhotos[] = "uploads/patients/{$patientFolder}/cancer_photos/{$filename}";
                    $xrayHashes[] = hash_file('sha256', $cancerPath . DIRECTORY_SEPARATOR . $filename);

                    $nextNumber++;
                }

                PatientCancerPhoto::create([
                    'patient_id' => $patient->id,
                    'total_cancer' => $request->total_cancer,
                    'xray_photo' => $xrayPhotos,
                    'cancer_hashes' => $xrayHashes,
                    'xray_description' => $request->xray_description,
                    'cancer_remarks' => $request->cancer_remarks,
                ]);
            }
        }

        /* Upload Referred Documents*/
        if ($request->hasFile('documents')) {
            $nextNumber = 1;

            foreach (File::files($documentPath) as $file) {
                if (preg_match('/^document_(\d+)/', pathinfo($file->getFilename(), PATHINFO_FILENAME), $match)) {
                    $nextNumber = max($nextNumber, ((int)$match[1]) + 1);
                }
            }

            foreach ($request->file('documents') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());

                $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($extension, $imageExtensions)) {
                    $filename = "document_{$nextNumber}.webp";
                    Image::load($file->getRealPath())
                        ->width(1800)
                        ->format('webp')
                        ->quality(75)
                        ->save($documentPath . DIRECTORY_SEPARATOR . $filename);
                } else {

                    $filename = "document_{$nextNumber}.{$extension}";
                    $file->move($documentPath, $filename);
                }

                PatientDocument::create([
                    'patient_id' => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path' => "uploads/patients/{$patientFolder}/documents/{$filename}",
                    'document_type' => 'recommendation',
                    'file_hash' => hash_file('sha256', $documentPath . DIRECTORY_SEPARATOR . $filename),
                ]);

                $nextNumber++;
            }
        }


        /*Upload Treatment Images  */
        if (
            $validated['is_treatment'] &&
            $request->hasFile('treatment_images')
        ) {

            $treatmentImages = [];
            $treatmentHashes = [];

            $nextNumber = 1;

            foreach (File::files($treatmentPath) as $file) {

                if (
                    preg_match(
                        '/^treatment_(\d+)\.webp$/',
                        $file->getFilename(),
                        $match
                    )
                ) {
                    $nextNumber = max(
                        $nextNumber,
                        ((int) $match[1]) + 1
                    );
                }
            }

            foreach ($request->file('treatment_images') as $image) {

                $filename = "treatment_{$nextNumber}.webp";

                $fullPath =
                    $treatmentPath . DIRECTORY_SEPARATOR . $filename;

                Image::load($image->getRealPath())
                    ->width(1800)
                    ->format('webp')
                    ->quality(75)
                    ->save($fullPath);

                $treatmentImages[] =
                    "uploads/patients/{$patientFolder}/treatment_photos/{$filename}";

                $treatmentHashes[] =
                    hash_file('sha256', $fullPath);

                $nextNumber++;
            }

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT: Save Treatment Images + Hashes
            |--------------------------------------------------------------------------
            */

            $patient->update([
                'treatment_images' => $treatmentImages,
                'treatment_hashes' => $treatmentHashes,
            ]);
        }


        /* Upload Investigation Images*/
        if (
            $validated['is_investigated'] &&
            $request->hasFile('investigation_images')
        ) {

            $investigationImages = [];
            $investigationHashes = [];

            $nextNumber = 1;

            foreach (File::files($investigationPath) as $file) {

                if (
                    preg_match(
                        '/^investigation_(\d+)\.webp$/',
                        $file->getFilename(),
                        $match
                    )
                ) {
                    $nextNumber = max(
                        $nextNumber,
                        ((int) $match[1]) + 1
                    );
                }
            }

            foreach (
                $request->file('investigation_images') as $image
            ) {

                $filename =
                    "investigation_{$nextNumber}.webp";

                $fullPath =
                    $investigationPath .
                    DIRECTORY_SEPARATOR .
                    $filename;

                Image::load($image->getRealPath())
                    ->width(1800)
                    ->format('webp')
                    ->quality(75)
                    ->save($fullPath);

                $investigationImages[] =
                    "uploads/patients/{$patientFolder}/investigation_photos/{$filename}";

                $investigationHashes[] =
                    hash_file('sha256', $fullPath);

                $nextNumber++;
            }

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT: Save Investigation Images + Hashes
            |--------------------------------------------------------------------------
            */

            $patient->update([
                'investigation_images' => $investigationImages,
                'investigation_hashes' => $investigationHashes,
            ]);
        }


        /* Redirect*/
        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Patient registered successfully.'
            );
    }

    public function show($id)
    {
        $patient = Patient::with([
            'documents',
            'cancerPhotos',
        ])->findOrFail($id);

        return view('backend.patient_management.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load([
            'cancerPhotos',
        ]);

        $cancerPhoto = $patient->cancerPhotos->first();

        $xrayDescription = '';

        if ($cancerPhoto?->xray_description) {
            $decoded = json_decode(
                $cancerPhoto->xray_description,
                true
            );

            $xrayDescription = is_array($decoded)
                ? ($decoded['content'] ?? '')
                : $cancerPhoto->xray_description;
        }

        $cancerRemarks = '';

        if ($cancerPhoto?->cancer_remarks) {
            $decoded = json_decode(
                $cancerPhoto->cancer_remarks,
                true
            );

            $cancerRemarks = is_array($decoded)
                ? ($decoded['content'] ?? '')
                : $cancerPhoto->cancer_remarks;
        }

        $patient->setAttribute(
            'xray_description',
            $xrayDescription
        );

        $patient->setAttribute(
            'cancer_remarks',
            $cancerRemarks
        );

        $patientImage = $this->getPatientImageInfo($patient);
        $documents = $this->getReferredDocuments($patient);

        return view(
            'backend.patient_management.edit',
            array_merge(
                [
                    'patient' => $patient,
                    'cancerPhoto' => $cancerPhoto,
                    'documents' => $documents,
                ],
                $patientImage
            )
        );
    }

    private function formatBytes($bytes, $precision = 2)
    {
        if (!$bytes || $bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $pow = floor(log($bytes, 1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private function getPatientImageInfo(Patient $patient): array
    {
        if (!empty($patient->patient_image)) {
            $patientImagePath = Str::startsWith($patient->patient_image, 'uploads/')
                ? $patient->patient_image
                : 'uploads/images/patients/' . $patient->patient_image;
        } else {
            $patientImagePath = 'uploads/images/default.jpg';
        }

        $patientImageUrl = asset($patientImagePath);
        $patientImageFullPath = public_path($patientImagePath);
        $patientImageName = basename($patientImagePath);

        $patientImageSize = file_exists($patientImageFullPath)
            ? filesize($patientImageFullPath)
            : 0;

        $patientImageSizeFormatted = $this->formatBytes($patientImageSize);

        $patientImageWidth = null;
        $patientImageHeight = null;
        $patientImageMime = null;
        $patientImageOrientation = 'Unknown';
        $patientImageAspectCategory = 'Unknown';
        $patientImageExtension = strtolower(pathinfo($patientImageName, PATHINFO_EXTENSION));

        if (file_exists($patientImageFullPath)) {

            $imgInfo = @getimagesize($patientImageFullPath);

            if ($imgInfo) {

                $patientImageWidth = $imgInfo[0] ?? null;
                $patientImageHeight = $imgInfo[1] ?? null;
                $patientImageMime = $imgInfo['mime'] ?? null;

                if ($patientImageWidth && $patientImageHeight) {

                    if ($patientImageWidth > $patientImageHeight) {
                        $patientImageOrientation = 'Landscape';
                    } elseif ($patientImageHeight > $patientImageWidth) {
                        $patientImageOrientation = 'Portrait';
                    } else {
                        $patientImageOrientation = 'Square';
                    }

                    $ratio = round($patientImageWidth / $patientImageHeight, 2);

                    if ($patientImageWidth == $patientImageHeight) {
                        $patientImageAspectCategory = 'Square';
                    } elseif ($ratio >= 1.45 && $ratio <= 1.55) {
                        $patientImageAspectCategory = '3:2 Rectangular';
                    } elseif ($ratio >= 1.70 && $ratio <= 1.82) {
                        $patientImageAspectCategory = '16:9 Wide';
                    } elseif ($ratio > 1) {
                        $patientImageAspectCategory = 'Horizontal Rectangular';
                    } else {
                        $patientImageAspectCategory = 'Vertical Rectangular';
                    }
                }
            }
        }

        return [
            'patientImagePath' => $patientImagePath,
            'patientImageUrl' => $patientImageUrl,
            'patientImageName' => $patientImageName,
            'patientImageSize' => $patientImageSize,
            'patientImageSizeFormatted' => $patientImageSizeFormatted,
            'patientImageWidth' => $patientImageWidth,
            'patientImageHeight' => $patientImageHeight,
            'patientImageMime' => $patientImageMime,
            'patientImageOrientation' => $patientImageOrientation,
            'patientImageAspectCategory' => $patientImageAspectCategory,
            'patientImageExtension' => $patientImageExtension,
        ];
    }

    private function getReferredDocuments(Patient $patient)
    {
        return $patient->documents
            ->where('document_type', 'recommendation')
            ->map(function ($doc) {

                $extension = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));

                $isImage = in_array($extension, [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                    'gif',
                    'bmp'
                ]);

                $fullPath = public_path($doc->file_path);

                $fileSize = file_exists($fullPath)
                    ? filesize($fullPath)
                    : 0;

                $mimeType = file_exists($fullPath)
                    ? @mime_content_type($fullPath)
                    : null;

                $width = null;
                $height = null;
                $orientation = 'Unknown';
                $aspectCategory = 'Unknown';

                if ($isImage && file_exists($fullPath)) {

                    $imageInfo = @getimagesize($fullPath);

                    if ($imageInfo) {

                        $width = $imageInfo[0] ?? null;
                        $height = $imageInfo[1] ?? null;

                        $mimeType = $imageInfo['mime'] ?? $mimeType;

                        if ($width && $height) {

                            if ($width > $height) {
                                $orientation = 'Landscape';
                            } elseif ($height > $width) {
                                $orientation = 'Portrait';
                            } else {
                                $orientation = 'Square';
                            }

                            $ratio = round($width / $height, 2);

                            if ($width == $height) {
                                $aspectCategory = 'Square';
                            } elseif ($ratio >= 1.45 && $ratio <= 1.55) {
                                $aspectCategory = '3:2 Rectangular';
                            } elseif ($ratio >= 1.70 && $ratio <= 1.82) {
                                $aspectCategory = '16:9 Wide';
                            } elseif ($ratio > 1) {
                                $aspectCategory = 'Horizontal Rectangular';
                            } else {
                                $aspectCategory = 'Vertical Rectangular';
                            }
                        }
                    }
                }

                $doc->file_url = asset($doc->file_path);
                $doc->extension = $extension;
                $doc->is_image = $isImage;
                $doc->file_size = $fileSize;
                $doc->file_size_formatted = $this->formatBytes($fileSize);
                $doc->mime_type = $mimeType;
                $doc->width = $width;
                $doc->height = $height;
                $doc->orientation = $orientation;
                $doc->aspect_category = $aspectCategory;

                return $doc;
            });
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            /* Patient Identity*/
            'patient_name' => 'required|string|max:255',
            'patient_f_name' => 'required|string|max:255',
            'patient_m_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:100',

            'gender' => ['required', 'in:male,female',],
            /* Contact  */
            'phone_1' => 'required|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'phone_f_1' => 'nullable|string|max:20',
            'phone_m_1' => 'nullable|string|max:20',

            /* Location */
            'location_type' => 'required|in:1,2,3',

            'location_simple' => 'nullable|string',

            'house_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:20',

            'country' => 'nullable|string|max:255',
            'passport_no' => 'nullable|string|max:100',

            /* Patient Information*/
            'patient_problem_description' => 'nullable|string',
            'patient_drug_description' => 'nullable|string',
            'remarks' => 'nullable|string',

            /*Recommendation */
            'referred_doctor_name' => 'nullable|string|max:255',
            'referred_note' => 'nullable|string',

            /* Treatment   */
            'treatment_information' => 'nullable|string',
            'treatment_type' => ['nullable',],
            'treatment_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120',],

            /* Investigation   */
            'investigation_information' => 'nullable|string',

            'investigation_images.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            /* Hospital  */
            'date_of_patient_added' => 'required|date',

            /* Referred Documents  */
            'documents.*' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

            /* Cancer */
            'total_cancer' => 'nullable|integer|min:1',
            'xray_photo.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'xray_description' => 'nullable|string',
            'cancer_remarks' => 'nullable|string',

            /* Emergency */
            'reason' => 'nullable|string|max:500',
            'emergency_date' => 'nullable|date',

            /* Patient Profile Photo */
            'patient_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /* Boolean Values */
        $validated['is_referred'] = $request->boolean('is_referred');
        $validated['is_emergency'] = $request->boolean('is_emergency');
        $validated['is_old_cancer'] = $request->boolean('is_old_cancer');
        $validated['is_treatment'] = $request->boolean('is_treatment');
        $validated['is_investigated'] = $request->boolean('is_investigated');

        /*Treatment Cleanup */
        if (!$validated['is_treatment']) {
            $validated['treatment_information'] = null;
            $validated['treatment_type'] = null;
            $validated['treatment_images'] = null;
        }

        /*Investigation Cleanup  */
        if (!$validated['is_investigated']) {
            $validated['investigation_information'] = null;
            $validated['investigation_type'] = null;
            $validated['investigation_images'] = null;
        }

        if (!$validated['is_old_cancer']) {
            $validated['total_cancer'] = null;
        }

        /* Location Cleanup  */
        if ($request->location_type != 1) {
            $validated['location_simple'] = null;
        }

        if ($request->location_type != 2) {
            $validated['house_address'] = null;
            $validated['city'] = null;
            $validated['district'] = null;
            $validated['post_code'] = null;
        }

        if ($request->location_type != 3) {
            $validated['country'] = null;
            $validated['passport_no'] = null;
        }

        /* Remove Uploaded File Fields Before Update */
        unset(
            $validated['documents'],
            $validated['patient_photo'],
            $validated['treatment_images'],
            $validated['investigation_images'],
            $validated['xray_photo'],
            $validated['xray_description'],
            $validated['total_cancer'],
            $validated['cancer_remarks'],
            $validated['reason'],
            $validated['emergency_date'],
        );

        /* Update Patient */
        $patient->update($validated);
        /* Patient Folder */
        $patientFolder = Str::slug($patient->patient_name . '-' . $patient->id);

        /*Folder Paths*/
        $imagePath = public_path("uploads/patients/{$patientFolder}/image");
        $documentPath = public_path("uploads/patients/{$patientFolder}/documents");
        $treatmentPath = public_path("uploads/patients/{$patientFolder}/treatment_photos");
        $investigationPath = public_path("uploads/patients/{$patientFolder}/investigation_photos");
        $cancerPath = public_path("uploads/patients/{$patientFolder}/cancer_photos");

        /*Ensure Directories*/
        File::ensureDirectoryExists($imagePath);
        File::ensureDirectoryExists($documentPath);
        File::ensureDirectoryExists($treatmentPath);
        File::ensureDirectoryExists($investigationPath);
        File::ensureDirectoryExists($cancerPath);

        $documents = PatientDocument::where('patient_id', $patient->id)->get();
        foreach ($documents as $document) {
            if (str_starts_with($document->file_path, 'uploads/images/patients/')) {
                $newPath = $this->migrateOldImage(
                    $document->file_path,
                    $documentPath,
                    'document'
                );
                if ($newPath !== $document->file_path) {
                    $document->update([
                        'file_path' => $newPath,
                        'file_hash' => hash_file('sha256', public_path($newPath)),
                    ]);
                }
            }
        }
        /* Upload Referred Documents */
        if ($request->hasFile('documents')) {
            $nextNumber = 1;
            foreach (File::files($documentPath) as $file) {
                if (preg_match('/^document_(\d+)/', $file->getFilename(), $match)) {
                    $nextNumber = max($nextNumber, ((int)$match[1]) + 1);
                }
            }

            foreach ($request->file('documents') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($extension, $imageExtensions)) {
                    $filename = "document_{$nextNumber}.webp";
                    Image::load($file->getRealPath())
                        ->width(1800)
                        ->format('webp')
                        ->quality(75)
                        ->save($documentPath . DIRECTORY_SEPARATOR . $filename);
                } else {
                    $filename = "document_{$nextNumber}.{$extension}";
                    $file->move($documentPath, $filename);
                }

                PatientDocument::create([
                    'patient_id' => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path' => "uploads/patients/{$patientFolder}/documents/{$filename}",
                    'document_type' => 'recommendation',
                    'file_hash' => hash_file(
                        'sha256',
                        $documentPath . DIRECTORY_SEPARATOR . $filename
                    ),
                ]);
                $nextNumber++;
            }
        }

        /* Update Emergency Information*/
        if ($validated['is_emergency']) {
            $emergency = PatientEmergency::firstOrNew([
                'patient_id' => $patient->id,
            ]);

            $emergency->is_emergency = true;
            $emergency->reason = $request->reason;
            $emergency->emergency_date = $request->emergency_date;
            $emergency->save();
        } else {
            PatientEmergency::where('patient_id', $patient->id)->delete();
        }


        /* Migrate Old Treatment Images*/
        $treatmentImages = $patient->treatment_images ?? [];
        $treatmentHashes = $patient->treatment_hashes ?? [];
        foreach ($treatmentImages as $key => $oldImage) {

            $newPath = $this->migrateOldImage(
                $oldImage,
                $treatmentPath,
                'treatment'
            );

            if ($newPath !== $oldImage) {

                $treatmentImages[$key] = $newPath;
                $treatmentHashes[$key] = hash_file('sha256', public_path($newPath));
            }
        }

        $patient->update([
            'treatment_images' => $treatmentImages,
            'treatment_hashes' => $treatmentHashes,
        ]);

        /* Upload Treatment Images */
        if ($validated['is_treatment'] && $request->hasFile('treatment_images')) {
            $treatmentImages = $patient->treatment_images ?? [];
            $treatmentHashes = $patient->treatment_hashes ?? [];
            $nextNumber = 1;
            foreach (File::files($treatmentPath) as $file) {
                if (preg_match('/^treatment_(\d+)\.webp$/', $file->getFilename(), $match)) {
                    $nextNumber = max(
                        $nextNumber,
                        ((int)$match[1]) + 1
                    );
                }
            }

            foreach ($request->file('treatment_images') as $image) {
                $filename = "treatment_{$nextNumber}.webp";
                Image::load($image->getRealPath())
                    ->width(1800)
                    ->format('webp')
                    ->quality(75)
                    ->save($treatmentPath . DIRECTORY_SEPARATOR . $filename);


                $treatmentImages[] = "uploads/patients/{$patientFolder}/treatment_photos/{$filename}";
                $treatmentHashes[] = hash_file(
                    'sha256',
                    $treatmentPath . DIRECTORY_SEPARATOR . $filename
                );

                $nextNumber++;
            }

            $patient->update([
                'treatment_images' => $treatmentImages,
                'treatment_hashes' => $treatmentHashes,
            ]);
        }

        /* Migrate Old Investigation Images */
        $investigationImages = $patient->investigation_images ?? [];
        $investigationHashes = $patient->investigation_hashes ?? [];

        foreach ($investigationImages as $key => $oldImage) {

            $newPath = $this->migrateOldImage(
                $oldImage,
                $investigationPath,
                'investigation'
            );

            if ($newPath !== $oldImage) {

                $investigationImages[$key] = $newPath;
                $investigationHashes[$key] = hash_file('sha256', public_path($newPath));
            }
        }

        $patient->update([
            'investigation_images' => $investigationImages,
            'investigation_hashes' => $investigationHashes,
        ]);

        /* Upload Investigation Images */
        if ($validated['is_investigated'] && $request->hasFile('investigation_images')) {
            $investigationImages = $patient->investigation_images ?? [];
            $investigationHashes = $patient->investigation_hashes ?? [];
            $nextNumber = 1;

            foreach (File::files($investigationPath) as $file) {
                if (preg_match('/^investigation_(\d+)\.webp$/', $file->getFilename(), $match)) {
                    $nextNumber = max($nextNumber, ((int)$match[1]) + 1);
                }
            }

            foreach ($request->file('investigation_images') as $image) {
                $filename = "investigation_{$nextNumber}.webp";
                Image::load($image->getRealPath())
                    ->width(1800)
                    ->format('webp')
                    ->quality(75)
                    ->save($investigationPath . DIRECTORY_SEPARATOR . $filename);

                $investigationImages[] = "uploads/patients/{$patientFolder}/investigation_photos/{$filename}";

                $investigationHashes[] =
                    hash_file(
                        'sha256',
                        $investigationPath . DIRECTORY_SEPARATOR . $filename
                    );

                $nextNumber++;
            }

            $patient->update([
                'investigation_images' => $investigationImages,
                'investigation_hashes' => $investigationHashes,
            ]);
        }

        /*Migrate Old Cancer Images*/
        $cancer = PatientCancerPhoto::where('patient_id', $patient->id)->first();

        if ($cancer) {
            $photos = $cancer->xray_photo ?? [];
            $hashes = $cancer->cancer_hashes ?? [];

            foreach ($photos as $key => $oldImage) {
                $newPath = $this->migrateOldImage($oldImage, $cancerPath, 'cancer');
                if ($newPath !== $oldImage) {
                    $photos[$key] = $newPath;
                    $hashes[$key] = hash_file('sha256', public_path($newPath));
                }
            }

            $cancer->update([
                'xray_photo' => $photos,
                'cancer_hashes' => $hashes,
            ]);
        }

        /*Update Cancer Information*/
        $cancer = PatientCancerPhoto::firstOrNew(['patient_id' => $patient->id]);

        if ($validated['is_old_cancer']) {
            $cancer = $cancer ?: new PatientCancerPhoto();

            /* Existing Cancer Images  */
            $photos = is_array($cancer->xray_photo) ? $cancer->xray_photo : [];
            $hashes = is_array($cancer->cancer_hashes) ? $cancer->cancer_hashes : [];

            /* Migrate Old Cancer Images */
            foreach ($photos as $key => $oldImage) {
                if (!$oldImage) {
                    continue;
                }

                $newPath = $this->migrateOldImage($oldImage, $cancerPath, 'cancer');

                if ($newPath !== $oldImage) {
                    $photos[$key] = $newPath;
                    $absolutePath = public_path($newPath);

                    if (File::exists($absolutePath)) {
                        $hashes[$key] = hash_file(
                            'sha256',
                            $absolutePath
                        );
                    }
                }
            }

            /*Upload New Cancer Images */
            if ($request->hasFile('xray_photo')) {
                $nextNumber = 1;
                foreach (File::files($cancerPath) as $file) {
                    if (
                        preg_match('/^cancer_(\d+)\.webp$/', $file->getFilename(), $match)
                    ) {
                        $nextNumber = max($nextNumber, ((int) $match[1]) + 1);
                    }
                }

                foreach ($request->file('xray_photo') as $image) {
                    $filename = "cancer_{$nextNumber}.webp";
                    $fullPath = $cancerPath . DIRECTORY_SEPARATOR . $filename;

                    Image::load($image->getRealPath())
                        ->width(1800)
                        ->format('webp')
                        ->quality(75)
                        ->save($fullPath);

                    $photos[] = "uploads/patients/{$patientFolder}/cancer_photos/{$filename}";
                    $hashes[] = hash_file('sha256', $fullPath);
                    $nextNumber++;
                }
            }

            /*
            | Save Cancer Information
            | xray_description and cancer_remarks are SINGLE values.
            | They are not connected to individual images.
            */

            $cancer->patient_id = $patient->id;
            $cancer->total_cancer = $request->total_cancer;
            $cancer->xray_photo = array_values($photos);
            $cancer->cancer_hashes = array_values($hashes);
            $cancer->xray_description = $request->filled('xray_description')
                ? json_encode([
                    'content' => $request->xray_description,
                ], JSON_UNESCAPED_UNICODE)
                : null;

            $cancer->cancer_remarks = $request->filled('cancer_remarks')
                ? json_encode([
                    'content' => $request->cancer_remarks,
                ], JSON_UNESCAPED_UNICODE)
                : null;
            $cancer->save();
        } else {

            /*Cancer Disabled */
            if ($cancer) {
                $cancer->delete();
            }

            /* Remove Cancer Files= */
            if (File::exists($cancerPath)) {
                File::deleteDirectory($cancerPath);
                File::ensureDirectoryExists($cancerPath);
            }
        }

        /* Migrate Old Profile Photo */

        if (
            $patient->patient_photo &&
            str_starts_with($patient->patient_photo, 'uploads/images/patients/')
        ) {

            $newProfile = $this->migrateOldImage(
                $patient->patient_photo,
                $imagePath,
                'patient_profile'
            );

            if ($newProfile !== $patient->patient_photo) {

                $patient->update([
                    'patient_photo' => $newProfile,
                    'photo_hash' => hash_file(
                        'sha256',
                        public_path($newProfile)
                    ),
                ]);
            }
        }

        /* Update Patient Profile Photo  */

        if ($request->hasFile('patient_photo')) {
            // Delete current profile image
            if (
                $patient->patient_photo &&
                file_exists(public_path($patient->patient_photo))
            ) {
                unlink(public_path($patient->patient_photo));
            }

            // Find next file number
            $nextNumber = 1;

            foreach (File::files($imagePath) as $file) {
                if (preg_match('/^patient_profile_(\d+)\.webp$/', $file->getFilename(), $match)) {
                    $nextNumber = max($nextNumber, ((int) $match[1]) + 1);
                }
            }

            $filename = "patient_profile_{$nextNumber}.webp";

            Image::load($request->file('patient_photo')->getRealPath())
                ->width(1800)
                ->format('webp')
                ->quality(75)
                ->save($imagePath . DIRECTORY_SEPARATOR . $filename);

            $patient->update([
                'patient_photo' => "uploads/patients/{$patientFolder}/image/{$filename}",
                'photo_hash' => hash_file(
                    'sha256',
                    $imagePath . DIRECTORY_SEPARATOR . $filename
                ),
            ]);
        }

        /*Redirect */
        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Patient updated successfully.'
            );
    }

    private function migrateOldImage($oldPath, $newDirectory, $prefix)
    {
        // Already migrated
        if (!str_starts_with($oldPath, 'uploads/images/patients/')) {
            return $oldPath;
        }

        $oldFullPath = public_path($oldPath);

        if (!file_exists($oldFullPath)) {
            return $oldPath;
        }

        File::ensureDirectoryExists($newDirectory);

        $nextNumber = 1;

        foreach (File::files($newDirectory) as $file) {
            if (preg_match("/^{$prefix}_(\\d+)\\.webp$/", $file->getFilename(), $match)) {
                $nextNumber = max($nextNumber, ((int) $match[1]) + 1);
            }
        }

        $filename = "{$prefix}_{$nextNumber}.webp";

        $newFullPath = $newDirectory . DIRECTORY_SEPARATOR . $filename;

        Image::load($oldFullPath)
            ->width(1800)
            ->format('webp')
            ->quality(75)
            ->save($newFullPath);

        if (file_exists($newFullPath)) {
            unlink($oldFullPath);
        }

        $relativePath = str_replace(public_path(), '', $newFullPath);

        return str_replace('\\', '/', ltrim($relativePath, '/'));
    }

    /* Save / Update Patient Draft*/
    public function saveDraft(Request $request)
    {
        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        $request->validate([
            'draft_token'  => ['required', 'uuid'],
            'form_data'    => ['required', 'array'],
            'current_step' => ['nullable', 'string'],
        ]);

        $draft = PatientDraft::updateOrCreate(
            [
                'draft_token' => $request->draft_token,
                'user_id'     => $user->id,
            ],
            [
                'form_data'     => $request->form_data,
                'current_step'  => $request->current_step,
                'last_saved_at' => now(),
            ]
        );

        return response()->json([
            'success'     => true,
            'draft_id'    => $draft->id,
            'draft_token' => $draft->draft_token,
            'saved_at'    => $draft->last_saved_at?->toISOString(),
        ]);
    }

    /* Get Pending Patient Drafts*/
    public function pendingDrafts()
    {
        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        $drafts = PatientDraft::where('user_id', $user->id)
            ->orderByDesc('last_saved_at')
            ->get();

        return response()->json([
            'success' => true,
            'count'   => $drafts->count(),

            'drafts' => $drafts->map(function ($draft) {
                return [
                    'id'            => $draft->id,
                    'draft_token'   => $draft->draft_token,
                    'current_step'  => $draft->current_step,
                    'last_saved_at' => $draft->last_saved_at?->toISOString(),
                ];
            })->values(),
        ]);
    }

    /*
|--------------------------------------------------------------------------
| Get One Patient Draft
|--------------------------------------------------------------------------
*/

    public function showDraft(PatientDraft $draft)
    {
        abort_unless(Auth::check(), 401);
        $user = Auth::user();

        /* Security - A user can only access their own draft.*/
        abort_unless(
            (int) $draft->user_id === (int) $user->id,
            403
        );

        return response()->json([
            'success' => true,

            'draft' => [
                'id'            => $draft->id,
                'draft_token'   => $draft->draft_token,
                'form_data'     => $draft->form_data,
                'current_step'  => $draft->current_step,
                'last_saved_at' => $draft->last_saved_at?->toISOString(),
            ],
        ]);
    }

    /*Delete Patient Draft*/
    public function destroyDraft(PatientDraft $draft)
    {
        abort_unless(Auth::check(), 401);
        $user = Auth::user();

        /* Security - A user can only delete their own draft. */
        abort_unless(
            (int) $draft->user_id === (int) $user->id,
            403
        );

        $draft->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient draft deleted successfully.',
        ]);
    }

    public function destroy(Patient $patient)
    {
        try {
            DB::beginTransaction();

            /* Patient Folder */
            $patientFolder = Str::slug(
                $patient->patient_name . '-' . $patient->id
            );

            $patientRootPath = public_path(
                "uploads/patients/{$patientFolder}"
            );

            /* Delete Related Database Records  */
            PatientEmergency::where('patient_id', $patient->id)->delete();
            PatientDocument::where('patient_id', $patient->id)->delete();
            PatientCancerPhoto::where('patient_id', $patient->id)->delete();

            /* Delete Patient */
            $patient->delete();

            /* Commit Database Changes */
            DB::commit();

            /* Delete Patient Files  */
            if (File::exists($patientRootPath)) {
                File::deleteDirectory($patientRootPath);
            }

            return back()->with(
                'success',
                'Patient and all associated files deleted successfully.'
            );
        } catch (\Throwable $e) {

            DB::rollBack();
            return back()->with(
                'error',
                'Unable to delete the patient. Please try again.'
            );
        }
    }

    public function deleteSelected(Request $request, PatientService $service)
    {
        return response()->json(
            $service->deleteSelected($request->ids)
        );
    }

    public function exportExcel(Request $request, PatientService $service)
    {
        return $service->exportExcel($request, $this->filteredPatients($request));
    }

    public function exportPdf(Request $request, PatientService $service)
    {
        return $service->exportPdf($request, $this->filteredPatients($request));
    }

    public function importExcel(Request $request, PatientService $service)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);

        return response()->json(
            $service->importExcel($request->file('file'))
        );
    }

    public function importWord(Request $request, PatientService $service)
    {
        $request->validate(['file' => 'required|mimes:doc,docx']);

        return response()->json(
            $service->importWord($request->file('file'))
        );
    }

    public function patientCardList()
    {
        $organization = Organization::first();

        return view(
            'backend.patient_management.patient_card_list',
            compact('organization')
        );
    }

    public function patientCardListSearch(Request $request)
    {
        $search = $request->input('search');

        $organization = Organization::first();

        $organizationLogo = $this->getOrganizationLogo(
            $organization
        );

        $patients = Patient::query()

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'patient_name',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'patient_code',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'phone_1',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'phone_2',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'patient_f_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'patient_m_name',
                            'like',
                            "%{$search}%"
                        );
                });
            })

            ->orderByRaw(
                'LOWER(patient_name) ASC'
            )

            ->paginate(20);

        return response()->json([

            'html' => view(

                'backend.patient_management.patient_card_items',

                [

                    'patients' => $patients,

                    'organization' => $organization,

                    'organizationLogo' => $organizationLogo,

                ]

            )->render(),


            'pagination' => $patients

                ->links(
                    'pagination::bootstrap-5'
                )

                ->render(),


            'total' => $patients->total(),

        ]);
    }

    private function getOrganizationLogo(
        ?Organization $organization
    ): ?string {

        if (
            !$organization ||
            !$organization->organization_picture
        ) {

            return null;
        }


        $basePath =
            'uploads/images/backend/organization/';


        $extensions = [
            'jpg',
            'jpeg',
            'png',
            'webp',
        ];


        foreach (
            $extensions as $extension
        ) {

            $relativePath =
                $basePath .
                $organization->organization_picture .
                '.' .
                $extension;


            if (
                file_exists(
                    public_path(
                        $relativePath
                    )
                )
            ) {

                return asset(
                    $relativePath
                );
            }
        }


        return null;
    }

    public function printCard($id, PatientService $service)
    {
        return $service->printCard($id);
    }
}
