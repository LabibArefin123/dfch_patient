<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientEmergency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientEmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patientEmergencies = PatientEmergency::with('patient')
            ->latest()
            ->get();

        return view(
            'backend.patient_management.patient_emergencies.index',
            compact('patientEmergencies')
        );
    }   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::where('is_emergency', 0)
            ->select('id', 'patient_name', 'patient_code')
            ->orderBy('patient_name')
            ->get();

        return view(
            'backend.patient_management.patient_emergencies.create',
            compact('patients')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'is_emergency'    => 'required|boolean',
            'reason'          => 'nullable|string|max:1000',
            'emergency_date'  => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            // Update current patient emergency status
            Patient::where('id', $validated['patient_id'])
                ->update([
                    'is_emergency' => $validated['is_emergency'],
                ]);

            // Store emergency history
            PatientEmergency::create($validated);
        });

        return redirect()
            ->route('patient_emergencies.index')
            ->with('success', 'Patient emergency information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientEmergency $patientEmergency)
    {
        $patientEmergency->load('patient');

        return view('backend.patient_management.patient_emergencies.show', compact('patientEmergency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientEmergency $patientEmergency)
    {
        $patients = Patient::where(function ($query) use ($patientEmergency) {
            $query->where('is_emergency', 0)
                ->orWhere('id', $patientEmergency->patient_id);
        })
            ->select('id', 'patient_name', 'patient_code')
            ->orderBy('patient_name')
            ->get();

        return view(
            'backend.patient_management.patient_emergencies.edit',
            compact('patientEmergency', 'patients')
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientEmergency $patientEmergency)
    {
        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'is_emergency'    => 'required|boolean',
            'reason'          => 'nullable|string|max:1000',
            'emergency_date'  => 'required|date',
        ]);

        DB::transaction(function () use ($validated, $patientEmergency) {

            // Update patient emergency status
            Patient::where('id', $validated['patient_id'])
                ->update([
                    'is_emergency' => $validated['is_emergency'],
                ]);

            // Update emergency history
            $patientEmergency->update($validated);
        });

        return redirect()
            ->route('patient_emergencies.index')
            ->with('success', 'Patient emergency information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientEmergency $patientEmergency)
    {
        DB::transaction(function () use ($patientEmergency) {

            /*
             |-------------------------------------------------------------
             | Restore patient's current emergency status
             |-------------------------------------------------------------
             | Find the latest emergency record (excluding this one).
             | If none exists, the patient becomes Normal.
             */
            $latestHistory = PatientEmergency::where('patient_id', $patientEmergency->patient_id)
                ->where('id', '!=', $patientEmergency->id)
                ->latest('emergency_date')
                ->latest('id')
                ->first();

            Patient::where('id', $patientEmergency->patient_id)
                ->update([
                    'is_emergency' => $latestHistory?->is_emergency ?? false,
                ]);

            $patientEmergency->delete();
        });

        return redirect()
            ->route('patient_emergencies.index')
            ->with('success', 'Patient emergency history deleted successfully.');
    }
}
