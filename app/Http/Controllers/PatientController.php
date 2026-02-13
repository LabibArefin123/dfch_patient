<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
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

                ->addColumn('action', function ($p) {
                    return '
            <a href="' . route('patients.edit', $p->id) . '" class="btn btn-warning btn-sm">Edit</a>
        ';
                })

                ->rawColumns(['patient_code', 'name', 'age', 'gender', 'phone', 'location', 'is_recommend', 'date', 'action'])
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

        Excel::import(new PatientsImport, $request->file('file'));

        return back()->with('success', 'Patients Imported Successfully');
    }

    public function importWord(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx'
        ]);

        // Custom Word import logic here

        return back()->with('success', 'Word File Imported Successfully');
    }

    public function print(Request $request)
    {
        $patients = Patient::all(); // apply filters if needed

        return view('backend.patient_management.print', compact('patients'));
    }
}
