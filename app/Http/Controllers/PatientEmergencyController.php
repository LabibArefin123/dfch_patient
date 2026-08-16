<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\PatientEmergency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientEmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $totalEmergencyPatientHistory = PatientEmergency::count();
        $todayEmergencyPatientHistory = PatientEmergency::whereDate('created_at', today())->count();
        $weeklyEmergencyPatientHistory = PatientEmergency::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthlyEmergencyPatientHistory = PatientEmergency::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        $query = PatientEmergency::with('patient')->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('patient_code', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'emergency') {
                $query->where('is_emergency', 1);
            } elseif ($request->status === 'normal') {
                $query->where('is_emergency', 0);
            }
        }

        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereBetween('emergency_date', [now()->startOfDay(), now()->endOfDay()]);
                    break;

                case 'yesterday':
                    $query->whereBetween('emergency_date', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                    break;

                case 'this_week':
                    $query->whereBetween('emergency_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;

                case 'last_week':
                    $query->whereBetween('emergency_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;

                case 'last_2_weeks':
                    $query->whereBetween('emergency_date', [now()->subWeeks(2)->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;

                case 'this_month':
                    $query->whereBetween('emergency_date', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;

                case 'custom':
                    if ($request->filled('date_from')) {
                        $query->where('emergency_date', '>=', Carbon::parse($request->date_from)->startOfDay());
                    }

                    if ($request->filled('date_to')) {
                        $query->where('emergency_date', '<=', Carbon::parse($request->date_to)->endOfDay());
                    }
                    break;
            }
        }

        $patientEmergencies = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'data' => $patientEmergencies->map(function ($emergency) {
                    $patient = $emergency->patient;

                    $photo = $patient?->patient_image
                        ? asset('uploads/images/patients/' . $patient->patient_image)
                        : asset('uploads/images/default.jpg');

                    return [
                        'id' => $emergency->id,
                        'patient_photo' => $photo,
                        'patient_code' => $patient?->patient_code ?? '-',
                        'patient_name' => $patient?->patient_name ?? '-',
                        'is_emergency' => (bool)$emergency->is_emergency,
                        'reason' => $emergency->reason ?: '-',
                        'emergency_date' => $emergency->emergency_date
                            ? $emergency->emergency_date->format('d M Y h:i A')
                            : '-',
                        'created_at' => $emergency->created_at
                            ? $emergency->created_at->format('d M Y')
                            : '-',
                    ];
                })->values(),
                'count' => $patientEmergencies->count(),
            ]);
        }

        return view(
            'backend.patient_management.patient_emergencies.index',
            compact(
                'patientEmergencies',
                'totalEmergencyPatientHistory',
                'todayEmergencyPatientHistory',
                'weeklyEmergencyPatientHistory',
                'monthlyEmergencyPatientHistory'
            )
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
