<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientDocument;
use Illuminate\Http\Request;

class PatientController extends Controller
{   
    public function index(Request $request)
    {
        $patients = Patient::query()

            ->when($request->patient_code, function ($q) use ($request) {
                $q->where('patient_code', 'like', '%' . $request->patient_code . '%');
            })

            ->when($request->patient_name, function ($q) use ($request) {
                $q->where('patient_name', 'like', '%' . $request->patient_name . '%');
            })

            ->when($request->phone, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('phone_1', 'like', '%' . $request->phone . '%')
                        ->orWhere('phone_2', 'like', '%' . $request->phone . '%')
                        ->orWhere('phone_f_1', 'like', '%' . $request->phone . '%')
                        ->orWhere('phone_m_1', 'like', '%' . $request->phone . '%');
                });
            })

            ->when($request->gender, function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })

            ->when($request->filled('is_recommend'), function ($q) use ($request) {
                $q->where('is_recommend', $request->is_recommend);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.patient_management.index', compact('patients'));
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
