<?php

namespace App\Http\Controllers;

use App\Services\Patient\PatientService;
use App\Models\Patient;
use Carbon\Carbon;
use App\Models\PatientCancerPhoto;
use App\Models\PatientDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Base Query with Filters
        $baseQuery = Patient::withCount('cancerPhotos')
            ->with('cancerPhotos')

            // Gender Filter
            ->when($request->gender, function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })

            // Recommendation Filter
            ->when($request->filled('is_recommend'), function ($q) use ($request) {
                $q->where('is_recommend', (int) $request->is_recommend);
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
            $childPatients  = (clone $baseQuery)->where('age', '<', 18)->count();
            $adultPatients  = (clone $baseQuery)->whereBetween('age', [18, 60])->count();
            $seniorPatients = (clone $baseQuery)->where('age', '>', 60)->count();

            return DataTables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('photo', function ($p) {

                    $photo = $p->patient_photo && file_exists(public_path($p->patient_photo))
                        ? asset($p->patient_photo)
                        : asset('uploads/images/default.jpg');

                    $formattedDate = $p->date_of_patient_added
                        ? Carbon::parse($p->date_of_patient_added)->format('d F Y')
                        : 'N/A';

                    return '
                    <div class="text-center">
                        <img src="' . $photo . '"
                            class="patient-img patient-image-modal-btn"
                            style="cursor:pointer"
                            alt="Patient"

                            data-photo="' . $photo . '"
                            data-name="' . e($p->patient_name) . '"
                            data-code="' . e($p->patient_code) . '"
                            data-age="' . e($p->age) . ' years old"
                            data-gender="' . e($p->gender) . '"
                            data-phone="' . e($p->phone_1) . '"
                            data-date="' . $formattedDate . '">
                    </div>';
                })
                ->rawColumns(['photo'])
                ->addColumn('patient_code', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $p->patient_code . '</a>';
                })

                ->addColumn('name', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box"><strong>' . $p->patient_name . '</strong><br>
                    <small class="text-muted">Father: ' . ($p->patient_f_name ?? 'N/A') . '</small><br>
                    <small class="text-muted">Mother: ' . ($p->patient_m_name ?? 'N/A') . '</small></a>';
                })

                ->addColumn('age', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $p->age . '</a>';
                })

                ->addColumn('gender', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . ucfirst($p->gender) . '</a>';
                })

                ->addColumn('phone', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' .
                        ($p->phone_1 ?? 'N/A') . '<br><small>Alt: ' . ($p->phone_2 ?? 'N/A') . '</small>' .
                        '<br><small>Father: ' . ($p->phone_f_1 ?? 'N/A') . '</small>' .
                        '<br><small>Mother: ' . ($p->phone_m_1 ?? 'N/A') . '</small>' .
                        '</a>';
                })

                ->addColumn('location', function ($p) {
                    $loc = $p->location_type == 1 ? $p->location_simple : ($p->location_type == 2 ? $p->city . '<br>' . $p->district : $p->country);
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $loc . '</a>';
                })

                ->addColumn('is_recommend', function ($p) {
                    $status = $p->is_recommend ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>';
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' . $status . '</a>';
                })

                ->addColumn('does_old_cancer', function ($p) {

                    if ($p->cancerPhotos->isEmpty()) {
                        return '
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> No
                        </span>';
                    }

                    return '
                    <a href="' . route('patients.cancer.photos', $p) . '" class="hover-box">
                        <span class="badge badge-danger">
                            <i class="fas fa-radiation"></i> Yes
                        </span>
                    </a>';
                })

                ->addColumn('total_cancer_photos', function ($p) {
                    $reports = $p->cancerPhotos->count();
                    $totalCancer = $p->cancerPhotos->sum('total_cancer');
                    return '<a href="' . route('patients.cancer.photos', $p) . '">
                        <span class="badge badge-primary">
                            Reports : ' . $reports . '
                        </span>

                        <br>

                        <span class="badge badge-danger">
                            Cancer : ' . $totalCancer . '
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
                    'is_recommend',
                    'does_old_cancer',
                    'total_cancer_photos',
                    'date',
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

        // Initial Load (no filters)
        $childPatients  = Patient::where('age', '<', 18)->count();
        $adultPatients  = Patient::whereBetween('age', [18, 60])->count();
        $seniorPatients = Patient::where('age', '>', 60)->count();

        return view(
            'backend.patient_management.index',
            compact('childPatients', 'adultPatients', 'seniorPatients')
        );
    }

    public function patient_recommend(Request $request)
    {
        // Clean "null" string values
        foreach ($request->all() as $key => $value) {
            if ($value === 'null' || $value === '') {
                $request->merge([$key => null]);
            }
        }

        // Base Query
        $baseQuery = Patient::query()
            ->where('is_recommend', 1) // 🔥 ALWAYS recommended patients

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

            ->when($request->filled('date_filter'), function ($q) use ($request) {
                switch ($request->date_filter) {

                    case 'today':
                        $q->whereDate('date_of_patient_added', now()->toDateString());
                        break;

                    case 'this_month':
                        $q->whereBetween('date_of_patient_added', [
                            now()->startOfMonth()->toDateString(),
                            now()->endOfMonth()->toDateString()
                        ]);
                        break;

                    case 'last_month':
                        $q->whereMonth('date_of_patient_added', now()->subMonth()->month)
                            ->whereYear('date_of_patient_added', now()->subMonth()->year);
                        break;

                    case 'this_year':
                        $q->whereYear('date_of_patient_added', now()->year);
                        break;

                    case 'custom':
                        if ($request->filled(['from_date', 'to_date'])) {
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
            $adultPatients  = (clone $baseQuery)->whereBetween('age', [18, 60])->count();
            $seniorPatients = (clone $baseQuery)->where('age', '>', 60)->count();

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
                ->addColumn('is_recommend', fn() => '<span class="badge badge-success">Recommended</span>')
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

                ->rawColumns(['photo', 'patient_code', 'name', 'age', 'gender', 'phone', 'location', 'is_recommend', 'checkbox', 'action'])
                ->with([
                    'childPatients'  => $childPatients,
                    'adultPatients'  => $adultPatients,
                    'seniorPatients' => $seniorPatients,
                ])
                ->make(true);
        }

        // First Page Load
        $childPatients  = (clone $baseQuery)->where('age', '<', 18)->count();
        $adultPatients  = (clone $baseQuery)->whereBetween('age', [18, 60])->count();
        $seniorPatients = (clone $baseQuery)->where('age', '>', 60)->count();

        return view('backend.patient_management.recommend_index', compact('childPatients', 'adultPatients', 'seniorPatients'));
    }

    public function patientSummarySearch(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $search = trim($request->search);

        $patients = Patient::withCount([
            'documents',
            'cancerPhotos'
        ])
            ->where(function ($query) use ($search) {

                $query->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_code', 'like', "%{$search}%")
                    ->orWhere('phone_1', 'like', "%{$search}%")
                    ->orWhere('phone_2', 'like', "%{$search}%")
                    ->orWhere('phone_f_1', 'like', "%{$search}%")
                    ->orWhere('phone_m_1', 'like', "%{$search}%");
            })
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

                    'recommend' => $patient->is_recommend,

                    'doctor' => $patient->recommend_doctor_name,

                    'recommend_note' => $patient->recommend_note,

                    'documents' => $patient->documents_count,

                    'cancer_reports' => $patient->cancer_photos_count,

                    'date' => optional($patient->date_of_patient_added)
                        ->format('d F Y'),

                ];
            }),
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
                $request->filled('is_recommend'),
                fn($q) =>
                $q->where('is_recommend', (int)$request->is_recommend)
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

    public function create()
    {
        return view('backend.patient_management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name'                 => 'required|string|max:255',
            'patient_f_name'               => 'required|string|max:255',
            'patient_m_name'               => 'required|string|max:255',

            'phone_1'                      => 'required|string|max:20',
            'phone_2'                      => 'nullable|string|max:20',
            'phone_f_1'                    => 'nullable|string|max:20',
            'phone_m_1'                    => 'nullable|string|max:20',

            'age'                          => 'required|integer|min:0|max:100',
            'gender'                       => 'required|string',

            'location_type'                => 'required|in:1,2,3',

            'patient_problem_description'  => 'nullable|string|max:255',
            'patient_drug_description'     => 'nullable|string|max:255',
            'remarks'                      => 'nullable|string|max:255',

            'date_of_patient_added'        => 'required|date',

            'documents.*'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'images.*'                     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Boolean
    |--------------------------------------------------------------------------
    */
        $validated['is_recommend'] = $request->boolean('is_recommend');

        /*
    |--------------------------------------------------------------------------
    | Location Cleanup
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | Create Patient
    |--------------------------------------------------------------------------
    */
        $patient = Patient::create(
            array_merge(
                $validated,
                $request->except([
                    'documents',
                    'images',
                ])
            )
        );

        /*
    |--------------------------------------------------------------------------
    | Generate Patient Code
    |--------------------------------------------------------------------------
    */
        $patient->update([
            'patient_code' => 'DFCH-' . now()->format('Y') . '-' . str_pad(
                $patient->id,
                9,
                '0',
                STR_PAD_LEFT
            ),
        ]);

        /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
    */
        $patientFolder = Str::slug($patient->patient_name . '-' . $patient->id);

        $imagePath = public_path("uploads/images/patients/{$patientFolder}/image");
        $documentPath = public_path("uploads/documents/{$patientFolder}/recommend_doc");

        File::ensureDirectoryExists($imagePath);
        File::ensureDirectoryExists($documentPath);

        /*
    |--------------------------------------------------------------------------
    | Upload Patient Images
    |--------------------------------------------------------------------------
    */
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $image) {

                $extension = $image->getClientOriginalExtension();

                $filename = 'patient_' .
                    now()->format('YmdHis') .
                    '_' . ($index + 1) .
                    '.' . $extension;

                $image->move($imagePath, $filename);

                PatientCancerPhoto::create([
                    'patient_id' => $patient->id,
                    'image' => "uploads/images/patients/{$patientFolder}/image/{$filename}",
                ]);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Upload Recommendation Documents
    |--------------------------------------------------------------------------
    */
        if ($request->hasFile('documents')) {

            foreach ($request->file('documents') as $index => $file) {

                $extension = $file->getClientOriginalExtension();

                $filename = 'recommend_doc_' .
                    now()->format('YmdHis') .
                    '_' . ($index + 1) .
                    '.' . $extension;

                $file->move($documentPath, $filename);

                PatientDocument::create([
                    'patient_id'    => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path'     => "uploads/documents/{$patientFolder}/recommend_doc/{$filename}",
                    'document_type' => 'recommendation',
                ]);
            }
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient registered successfully.');
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
        return view('backend.patient_management.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'patient_name'                 => 'required|string|max:255',
            'patient_f_name'               => 'required|string|max:255',
            'patient_m_name'               => 'required|string|max:255',

            'phone_1'                      => 'required|string|max:20',
            'phone_2'                      => 'nullable|string|max:20',
            'phone_f_1'                    => 'nullable|string|max:20',
            'phone_m_1'                    => 'nullable|string|max:20',

            'age'                          => 'required|integer|min:0|max:100',
            'gender'                       => 'required|string',

            'location_type'                => 'required|in:1,2,3',

            'patient_problem_description'  => 'nullable|string|max:255',
            'patient_drug_description'     => 'nullable|string|max:255',
            'remarks'                      => 'nullable|string|max:255',

            'date_of_patient_added'        => 'required|date',

            'documents.*'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'patient_photo'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Boolean
    |--------------------------------------------------------------------------
    */
        $validated['is_recommend'] = $request->boolean('is_recommend');

        /*
    |--------------------------------------------------------------------------
    | Location Cleanup
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | Update Patient
    |--------------------------------------------------------------------------
    */
        $patient->update(
            array_merge(
                $validated,
                $request->except([
                    'documents',
                    'patient_photo',
                ])
            )
        );

        /*
    |--------------------------------------------------------------------------
    | Patient Folder
    |--------------------------------------------------------------------------
    */
        $patientFolder = Str::slug($patient->patient_name . '-' . $patient->id);

        $documentPath = public_path("uploads/documents/{$patientFolder}/recommend_doc");
        $profilePath  = public_path("uploads/images/patients/{$patientFolder}/profile");

        File::ensureDirectoryExists($documentPath);
        File::ensureDirectoryExists($profilePath);

        /*
    |--------------------------------------------------------------------------
    | Upload Recommendation Documents
    |--------------------------------------------------------------------------
    */
        if ($request->hasFile('documents')) {

            foreach ($request->file('documents') as $index => $file) {

                $extension = $file->getClientOriginalExtension();

                $filename = 'recommend_doc_' .
                    now()->format('YmdHis') .
                    '_' . ($index + 1) .
                    '.' . $extension;

                $file->move($documentPath, $filename);

                PatientDocument::create([
                    'patient_id'    => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path'     => "uploads/documents/{$patientFolder}/recommend_doc/{$filename}",
                    'document_type' => 'recommendation',
                ]);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Update Patient Profile Photo
    |--------------------------------------------------------------------------
    */
        if ($request->hasFile('patient_photo')) {

            // Delete old profile photo
            if (
                $patient->patient_photo &&
                file_exists(public_path($patient->patient_photo))
            ) {
                unlink(public_path($patient->patient_photo));
            }

            $file = $request->file('patient_photo');

            $extension = $file->getClientOriginalExtension();

            $filename = 'patient_profile_' .
                now()->format('YmdHis') .
                '.' . $extension;

            $file->move($profilePath, $filename);

            $patient->update([
                'patient_photo' => "uploads/images/patients/{$patientFolder}/profile/{$filename}",
            ]);
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient deleted successfully');
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

    public function printCard($id, PatientService $service)
    {
        return $service->printCard($id);
    }
}
