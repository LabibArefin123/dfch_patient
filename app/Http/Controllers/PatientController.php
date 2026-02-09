<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $patients = Patient::query()

                // Gender
                ->when(
                    $request->gender,
                    fn($q) =>
                    $q->where('gender', $request->gender)
                )

                // Recommendation
                ->when(
                    $request->filled('is_recommend'),
                    fn($q) =>
                    $q->where('is_recommend', $request->is_recommend)
                )

                // Location filtering
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

                // Date filters
                ->when(
                    $request->date_filter === 'last_week',
                    fn($q) =>
                    $q->whereDate('date_of_patient_added', '>=', now()->subWeek())
                )
                ->when(
                    $request->date_filter === 'last_month',
                    fn($q) =>
                    $q->whereDate('date_of_patient_added', '>=', now()->subMonth())
                )
                ->when(
                    $request->date_filter === 'last_2_months',
                    fn($q) =>
                    $q->whereDate('date_of_patient_added', '>=', now()->subMonths(2))
                )
                ->when(
                    $request->filled(['from_date', 'to_date']),
                    fn($q) =>
                    $q->whereBetween('date_of_patient_added', [$request->from_date, $request->to_date])
                );

            return DataTables::of($patients)
                ->addIndexColumn()

                ->editColumn(
                    'name',
                    fn($p) =>
                    '<strong>' . $p->patient_name . '</strong><br>
                 <small class="text-muted">Father: ' . ($p->patient_f_name ?? 'N/A') . '</small><br>
                 <small class="text-muted">Mother: ' . ($p->patient_m_name ?? 'N/A') . '</small>'
                )

                ->editColumn('gender', fn($p) => ucfirst($p->gender))

                ->editColumn('phone', function ($p) {
                    return ($p->phone_1 ?? 'N/A') .
                        '<br><small>Alt Phone: ' . ($p->phone_2 ?? 'N/A') . '</small>' .
                        '<br><small>Father\'s Phone: ' . ($p->phone_f_1 ?? 'N/A') . '</small>' .
                        '<br><small>Mother\'s Phone: ' . ($p->phone_m_1 ?? 'N/A') . '</small>';
                })

                ->addColumn('location', function ($p) {
                    if ($p->location_type == 1) return $p->location_simple;
                    if ($p->location_type == 2) return $p->city . '<br>' . $p->district;
                    return $p->country;
                })

                ->editColumn(
                    'is_recommend',
                    fn($p) =>
                    $p->is_recommend
                        ? '<span class="badge badge-success">Yes</span>'
                        : '<span class="badge badge-secondary">No</span>'
                )

                ->editColumn(
                    'date',
                    fn($p) =>
                    optional($p->date_of_patient_added)->format('d M Y')
                )

                ->addColumn('action', function ($p) {
                    return '
                    <a href="' . route('patients.show', $p->id) . '" class="btn btn-info btn-sm me-1">
                        View
                    </a>

                    <a href="' . route('patients.edit', $p->id) . '" class="btn btn-warning btn-sm me-1">
                        Edit
                    </a>

                    <form action="' . route('patients.destroy', $p->id) . '" method="POST"
                        style="display:inline-block;"
                        onsubmit="return confirm(\'Are you sure you want to delete this patient?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                ';
                })

                ->rawColumns(['name', 'phone', 'location', 'is_recommend', 'action'])
                ->make(true);
        }

        return view('backend.patient_management.index');
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
            'age'                                => 'required|string|max:101',
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
}
