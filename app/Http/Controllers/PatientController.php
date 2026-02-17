<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\IOFactory;
use App\Imports\PatientsImport;
use App\Exports\PatientsExport;
use App\Models\PatientDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Base Query with Filters
        $baseQuery = Patient::query()

            // Gender Filter
            ->when($request->gender, function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })

            // Recommendation Filter
            ->when($request->filled('is_recommend'), function ($q) use ($request) {
                $q->where('is_recommend', (int) $request->is_recommend);
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

                ->addColumn('date', function ($p) {
                    return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">' .
                        \Carbon\Carbon::parse($p->date_of_patient_added)->format('d M Y') .
                        '</a>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })

                ->addColumn('action', function ($p) {

                    $editUrl   = route('patients.edit', $p->id);
                    $printUrl  = route('patients.print_card', $p->id);
                    $deleteUrl = route('patients.destroy', $p->id);

                    return '
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

                ->rawColumns(['patient_code', 'name', 'age', 'gender', 'phone', 'location', 'is_recommend', 'date', 'checkbox', 'action'])
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
                ->addColumn('action', function ($p) {

                    $editUrl   = route('patients.edit', $p->id);
                    $printUrl  = route('patients.print_card', $p->id);
                    $deleteUrl = route('patients.destroy', $p->id);

                    return '
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

                ->rawColumns(['patient_code', 'name', 'age', 'gender', 'phone', 'location', 'is_recommend', 'action'])
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
            'patient_name'                       => 'required|string|max:255',
            'patient_f_name'                     => 'required|string|max:255',
            'patient_m_name'                     => 'required|string|max:255',
            'phone_1'                            => 'required|string|max:20',
            'phone_2'                            => 'nullable|string|max:20',
            'phone_f_1'                          => 'nullable|string|max:20',
            'phone_m_1'                          => 'nullable|string|max:20',
            'age'                                => 'required|integer|min:0|max:100',
            'gender'                             => 'required|string',
            'location_type'                      => 'required|in:1,2,3',
            'patient_problem_description'        => 'nullable|string|max:255',
            'patient_drug_description'           => 'nullable|string|max:255',
            'remarks'                            => 'nullable|string|max:255',
            'date_of_patient_added'              => 'required|date',
            'documents.*'                        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        /* ============================
        AUTO PATIENT CODE
        ============================ */
        $validated['patient_code'] = 'DFCH-' . now()->format('Y') . '-' . str_pad(
            Patient::max('id') + 1,
            9,
            '0',
            STR_PAD_LEFT
        );

        /* ============================
        BOOLEAN FIX
        ============================ */
        $validated['is_recommend'] = $request->boolean('is_recommend');

        /* ============================
        LOCATION CLEANUP
    ============================ */
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

        /* ============================
        CREATE PATIENT
        ============================ */
        $patient = Patient::create(
            array_merge(
                $validated,
                $request->except(['documents'])
            )
        );

        /* ============================
        DOCUMENT UPLOAD
         ============================ */
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {

                $extension = $file->getClientOriginalExtension();

                $filename = 'recommend_doc_' .
                    now()->format('dmy') . '_' .
                    now()->format('sih') . '.' . $extension;

                $destinationPath = public_path('uploads/documents/recommend_doc');

                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                PatientDocument::create([
                    'patient_id'    => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path'     => 'uploads/documents/recommend_doc/' . $filename,
                    'document_type' => 'recommendation',
                ]);
            }
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient registered successfully');
    }

    public function show($id)
    {
        $patient = Patient::with('documents')->findOrFail($id);

        return view('backend.patient_management.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('backend.patient_management.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'patient_name'                       => 'required|string|max:255',
            'patient_f_name'                     => 'required|string|max:255',
            'patient_m_name'                     => 'required|string|max:255',
            'phone_1'                            => 'required|string|max:20',
            'phone_2'                            => 'nullable|string|max:20',
            'phone_f_1'                          => 'nullable|string|max:20',
            'phone_m_1'                          => 'nullable|string|max:20',
            'age'                                => 'required|string|max:101',
            'gender'                             => 'required|string',
            'location_type'                      => 'required|in:1,2,3',
            'patient_problem_description'        => 'nullable|string|max:255',
            'patient_drug_description'           => 'nullable|string|max:255',
            'remarks'                            => 'nullable|string|max:255',
            'date_of_patient_added'              => 'required|date|',
            'documents.*'                        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        /* ============================
        BOOLEAN FIX
    ============================ */
        $validated['is_recommend'] = $request->boolean('is_recommend');

        /* ============================
        LOCATION CLEANUP
    ============================ */
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

        /* ============================
        UPDATE PATIENT
    ============================ */
        $patient->update(
            array_merge(
                $validated,
                $request->except(['documents'])
            )
        );

        /* ============================
        ADD NEW DOCUMENTS
    ============================ */
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {

                $extension = $file->getClientOriginalExtension();

                $filename = 'recommend_doc_' .
                    now()->format('dmy') . '_' .
                    now()->format('sih') . '.' . $extension;

                $destinationPath = public_path('uploads/documents/recommend_doc');

                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                PatientDocument::create([
                    'patient_id'    => $patient->id,
                    'document_name' => $file->getClientOriginalName(),
                    'file_path'     => 'uploads/documents/recommend_doc/' . $filename,
                    'document_type' => 'recommendation',
                ]);
            }
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient deleted successfully');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return response()->json([
                'status' => false,
                'message' => 'No patients selected.'
            ]);
        }

        Patient::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected patients deleted successfully.'
        ]);
    }

    public function exportExcel(Request $request)
    {
        $patients = $this->filteredPatients($request)->get();

        return Excel::download(new PatientsExport($patients), 'patients.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $patients = $this->filteredPatients($request)->get();

        $pdf = Pdf::loadView(
            'backend.patient_management.pdf',
            compact('patients')
        );

        return $pdf->download('patients.pdf');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {

            $import = new PatientsImport;
            Excel::import($import, $request->file('file'));

            // If there are row validation failures
            if ($import->failures()->isNotEmpty()) {

                $errors = [];

                foreach ($import->failures() as $failure) {
                    $errors[] = "Row {$failure->row()} - " .
                        implode(', ', $failure->errors());
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Some rows failed validation.',
                    'errors' => $errors
                ], 422);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Patients Imported Successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Import failed. ' . $e->getMessage()
            ], 500);
        }
    }


    public function importWord(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx'
        ]);

        try {

            $file = $request->file('file');
            $phpWord = IOFactory::load($file->getPathname());

            $rows = [];

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {

                    if (method_exists($element, 'getRows')) {

                        foreach ($element->getRows() as $index => $row) {

                            $cells = $row->getCells();
                            $rowData = [];

                            foreach ($cells as $cell) {
                                $text = '';
                                foreach ($cell->getElements() as $cellElement) {
                                    if (method_exists($cellElement, 'getText')) {
                                        $text .= $cellElement->getText();
                                    }
                                }
                                $rowData[] = trim($text);
                            }

                            $rows[] = $rowData;
                        }
                    }
                }
            }

            if (count($rows) <= 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No data found in Word file.'
                ], 422);
            }

            // Remove heading row
            $headings = array_shift($rows);

            foreach ($rows as $row) {

                Patient::create([
                    'patient_name' => $row[0] ?? null,
                    'patient_f_name' => $row[1] ?? null,
                    'patient_m_name' => $row[2] ?? null,
                    'age' => $row[3] ?? null,
                    'gender' => $row[4] ?? null,
                    'phone_1' => $row[5] ?? null,
                    'phone_2' => $row[6] ?? null,
                    'phone_f_1' => $row[7] ?? null,
                    'phone_m_1' => $row[8] ?? null,
                    'location_type' => $row[9] ?? null,
                    'location_simple' => $row[10] ?? null,
                    'city' => $row[11] ?? null,
                    'district' => $row[12] ?? null,
                    'country' => $row[13] ?? null,
                    'is_recommend' => $row[14] ?? 0,
                    'date_of_patient_added' => $row[15] ?? Carbon::now()->toDateString(),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Patients Imported Successfully from Word'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Word import failed. ' . $e->getMessage()
            ], 500);
        }
    }

    public function printCard($id)
    {
        $patient = Patient::findOrFail($id);
        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.patient_management.print_card',
            compact('patient', 'organization')
        )->setPaper('a4', 'portrait');

        return $pdf->stream('patient_card_' . $patient->patient_code . '.pdf');
    }
}
