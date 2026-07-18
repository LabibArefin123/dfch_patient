<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientMeeting;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientMeetingController extends Controller
{
    /**
     * Display a listing of patient meetings.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $meetingType = $request->input('meeting_type');
        $date = $request->input('date');
        $specialists = Specialist::with([
            'meetings.patient:id,patient_name,patient_code,patient_photo',
        ])
            ->paginate(6);
        $patientMeetings = PatientMeeting::with([
            'patient:id,patient_name,patient_code,patient_photo',
            'specialist:id,name,designation,photo',
        ])

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")
                        ->orWhereHas('patient', function ($patientQuery) use ($search) {
                            $patientQuery
                                ->where('patient_name', 'like', "%{$search}%")
                                ->orWhere('patient_code', 'like', "%{$search}%");
                        })

                        ->orWhereHas('specialist', function ($specialistQuery) use ($search) {
                            $specialistQuery
                                ->where('name', 'like', "%{$search}%");
                        });
                });
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            ->when($meetingType, function ($query) use ($meetingType) {
                $query->where('meeting_type', $meetingType);
            })

            ->when($date, function ($query) use ($date) {
                $query->whereDate('meeting_date', $date);
            })

            ->latest('meeting_date')
            ->latest('start_time')
            ->paginate(10)

            ->withQueryString();

        return view(
            'backend.patient_management.patient_meetings.index',
            compact('patientMeetings', 'search', 'status', 'meetingType', 'date', 'specialists')
        );
    }

    public function patientsHistory(Specialist $specialist)
    {
        $specialist->load([
            'meetings.patient'
        ]);

        return view(
            'backend.patient_management.patient_meetings.patient_meetings',
            compact('specialist')
        );
    }
    /**
     * Show the form for creating a new meeting.
     */
    public function create()
    {
        $patients = Patient::query()
            ->select(['id', 'patient_name', 'patient_code',])
            ->orderBy('patient_name')
            ->get();


        $specialists = Specialist::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'backend.patient_management.patient_meetings.create',
            compact(
                'patients',
                'specialists'
            )
        );
    }

    /**
     * Store a newly created meeting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['nullable', 'exists:patients,id',],
            'specialist_id' => ['nullable', 'exists:specialists,id',],
            'title' => ['nullable', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'meeting_date' => ['required', 'date',],
            'start_time' => ['required', 'date_format:H:i',],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time',],
            'status' => ['required', Rule::in(['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show',]),],
            'meeting_type' => ['required', Rule::in(['consultation', 'follow_up', 'report_review', 'emergency', 'other',]),],
            'notes' => ['nullable', 'string',],
        ]);

        PatientMeeting::create($validated);

        return redirect()
            ->route('patient_meetings.index')
            ->with('success', 'Patient meeting scheduled successfully.');
    }

    /**
     * Display the specified meeting.
     */
    public function show(
        PatientMeeting $patientMeeting
    ) {
        $patientMeeting->load(['patient', 'specialist',]);
        return view(
            'backend.patient_management.patient_meetings.show',
            compact('patientMeeting')
        );
    }

    /**
     * Show the form for editing the specified meeting.
     */
    public function edit(
        PatientMeeting $patientMeeting
    ) {
        $patients = Patient::query()
            ->select(['id', 'patient_name', 'patient_code',])
            ->orderBy('patient_name')
            ->get();

        $specialists = Specialist::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();


        return view(
            'backend.patient_management.patient_meetings.edit',
            compact('patientMeeting', 'patients', 'specialists')
        );
    }


    /**
     * Update the specified meeting.
     */
    public function update(Request $request, PatientMeeting $patientMeeting)
    {
        $validated = $request->validate([
            'patient_id' => ['nullable', 'exists:patients,id',],
            'specialist_id' => ['nullable', 'exists:specialists,id',],
            'title' => ['nullable', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'meeting_date' => ['required', 'date',],
            'start_time' => ['required', 'date_format:H:i',],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time',],
            'status' => ['required', Rule::in(['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show',]),],
            'meeting_type' => ['required', Rule::in(['consultation', 'follow_up', 'report_review', 'emergency', 'other',]),],
            'notes' => ['nullable', 'string',],
        ]);


        $patientMeeting->update($validated);

        return redirect()
            ->route('patient_meetings.index')
            ->with('success', 'Patient meeting updated successfully.');
    }


    /**
     * Remove the specified meeting.
     */
    public function destroy(PatientMeeting $patientMeeting)
    {
        $patientMeeting->delete();

        return redirect()
            ->route('patient_meetings.index')
            ->with('success', 'Patient meeting deleted successfully.');
    }
}
