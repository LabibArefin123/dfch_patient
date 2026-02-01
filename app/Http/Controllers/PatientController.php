<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientDocument;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required',
            'phone_1' => 'required',
            'location_type' => 'required',
        ]);

        $patient = Patient::create($request->except('documents'));

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('patient_documents', 'public');

                PatientDocument::create([
                    'patient_id' => $patient->id,
                    'file_path' => $path,
                    'document_type' => 'recommendation',
                ]);
            }
        }

        return redirect()->route('patients.index')->with('success', 'Patient added successfully');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'patient_name' => 'required',
            'phone_1' => 'required',
            'location_type' => 'required',
        ]);

        $patient->update($request->except('documents'));

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('patient_documents', 'public');

                PatientDocument::create([
                    'patient_id' => $patient->id,
                    'file_path' => $path,
                    'document_type' => 'recommendation',
                ]);
            }
        }

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient deleted successfully');
    }
}
