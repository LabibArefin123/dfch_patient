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
        $filters = $this->getMeetingFilters($request);

        $filterSpecialists = $this->getFilterSpecialists();

        $specialists = $this->getSpecialists($filters);

        $this->prepareSpecialists($specialists);

        $patientMeetings = $this->getPatientMeetings($filters);

        if ($request->ajax()) {
            return view(
                'backend.patient_management.patient_meetings.partial_pages.index_page.meeting_table',
                compact('specialists', 'patientMeetings')
            )->render();
        }

        return view(
            'backend.patient_management.patient_meetings.index',
            compact(
                'patientMeetings',
                'filterSpecialists',
                'specialists',
                'filters'
            )
        );
    }
    private function getMeetingFilters(Request $request)
    {
        return [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'meeting_type' => $request->input('meeting_type'),
            'date' => $request->input('date'),
            'specialist_id' => $request->input('specialist_id'),
        ];
    }

    private function getFilterSpecialists()
    {
        return Specialist::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    private function getSpecialists(array $filters)
    {
        return Specialist::with([
            'meetings' => function ($query) use ($filters) {
                $this->applyMeetingFilters($query, $filters);

                $query->with([
                    'patient:id,patient_name,patient_code,patient_photo'
                ]);

                $query->latest('meeting_date')
                    ->latest('start_time');
            },
        ])
            ->when($filters['specialist_id'], function ($query) use ($filters) {
                $query->where('id', $filters['specialist_id']);
            })
            ->paginate(6)
            ->withQueryString();
    }

    private function applyMeetingFilters($query, array $filters)
    {
        $query->when($filters['status'], function ($query) use ($filters) {
            $query->where('status', $filters['status']);
        });

        $query->when($filters['meeting_type'], function ($query) use ($filters) {
            $query->where('meeting_type', $filters['meeting_type']);
        });

        $query->when($filters['date'], function ($query) use ($filters) {
            $query->whereDate('meeting_date', $filters['date']);
        });

        $query->when($filters['specialist_id'], function ($query) use ($filters) {
            $query->where('specialist_id', $filters['specialist_id']);
        });
    }

    private function getPatientMeetings(array $filters)
    {
        return PatientMeeting::with([
            'patient:id,patient_name,patient_code,patient_photo',
            'specialist:id,name,designation,photo',
        ])
            ->where(function ($query) use ($filters) {
                $this->applyMeetingFilters($query, $filters);
            })
            ->latest('meeting_date')
            ->latest('start_time')
            ->paginate(10)
            ->withQueryString();
    }

    private function prepareSpecialists($specialists)
    {
        $today = \Carbon\Carbon::today();

        $dates = [
            'yesterday' => $today->copy()->subDay(),
            'day_before' => $today->copy()->subDays(2),
        ];

        foreach ($specialists as $specialist) {
            $this->prepareSpecialistDoctor($specialist);
            $this->prepareSpecialistMeetings($specialist, $today, $dates);
        }
    }

    private function prepareSpecialistDoctor($specialist)
    {
        $specialist->doctor_image = $specialist->photo
            ? asset('uploads/images/welcome_page/doctors/' . $specialist->photo)
            : null;

        $specialist->doctor_initial = strtoupper(
            substr($specialist->name, 0, 1)
        );
    }

    private function prepareSpecialistMeetings($specialist, $today, array $dates)
    {
        $meetings = $specialist->meetings;

        $recent = $meetings->filter(function ($meeting) use ($today) {
            return optional($meeting->meeting_date)->isSameDay($today);
        })->values();

        $yesterday = $meetings->filter(function ($meeting) use ($dates) {
            return optional($meeting->meeting_date)
                ->isSameDay($dates['yesterday']);
        })->values();

        $dayBefore = $meetings->filter(function ($meeting) use ($dates) {
            return optional($meeting->meeting_date)
                ->isSameDay($dates['day_before']);
        })->values();

        $week = $meetings->filter(function ($meeting) {
            return optional($meeting->meeting_date)->isCurrentWeek();
        })->values();

        $month = $meetings->filter(function ($meeting) {
            return optional($meeting->meeting_date)->isCurrentMonth();
        })->values();

        $summaryMeetings = $this->buildSummaryMeetings(
            $recent,
            $yesterday,
            $dayBefore,
            $week,
            $month
        );

        $this->attachMeetingSummary(
            $specialist,
            $recent,
            $yesterday,
            $dayBefore,
            $week,
            $month,
            $summaryMeetings
        );

        $this->prepareSummaryCards($specialist);
    }

    private function buildSummaryMeetings(
        $recent,
        $yesterday,
        $dayBefore,
        $week,
        $month
    ) {
        return collect()
            ->merge($recent)
            ->merge($yesterday)
            ->merge($dayBefore)
            ->merge($week)
            ->merge($month)
            ->unique('id')
            ->sortByDesc('meeting_date')
            ->values();
    }

    private function attachMeetingSummary(
        $specialist,
        $recent,
        $yesterday,
        $dayBefore,
        $week,
        $month,
        $summaryMeetings
    ) {
        $specialist->meeting_summary = [
            'recent' => $recent,
            'yesterday' => $yesterday,
            'day_before' => $dayBefore,
            'week' => $week,
            'month' => $month,
            'meetings' => $summaryMeetings,

            'counts' => [
                'today' => $recent->count(),
                'yesterday' => $yesterday->count(),
                'day_before' => $dayBefore->count(),
                'week' => $week->count(),
                'month' => $month->count(),
                'total' => $summaryMeetings->count(),
            ],
        ];
    }

    private function prepareSummaryCards($specialist)
    {
        $meetings = $specialist->meeting_summary['meetings'];

        $pages = $meetings
            ->values()
            ->chunk(3)
            ->values();

        $specialist->summary_pages = $pages->map(function ($page, $pageIndex) {
            return [
                'index' => $pageIndex,
                'active' => $pageIndex === 0,
                'meetings' => $page->map(function ($meeting) {
                    return $this->prepareSummaryMeeting($meeting);
                })->values(),
            ];
        })->values();
    }

    private function prepareSummaryMeeting($meeting)
    {
        $patient = $meeting->patient;

        $patientName = $patient?->patient_name ?? 'Unknown Patient';

        $meetingTypeLabels = [
            'consultation' => 'Consultation',
            'follow_up' => 'Follow Up',
            'report_review' => 'Report Review',
            'emergency' => 'Emergency',
            'other' => 'Other',
        ];

        $meeting->summary_patient_name = $patientName;

        $meeting->summary_patient_initial = strtoupper(
            substr($patientName, 0, 1)
        );

        $meeting->summary_patient_code = $patient?->patient_code ?? 'N/A';

        $meeting->summary_patient_photo = $patient?->patient_photo
            ? asset($patient->patient_photo)
            : null;

        $meeting->summary_meeting_date = $meeting->meeting_date
            ? $meeting->meeting_date->format('d M Y')
            : 'Date unavailable';

        $meeting->summary_meeting_type =
            $meetingTypeLabels[$meeting->meeting_type] ?? 'Meeting';

        return $meeting;
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

    public function list(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $meetingType = $request->input('meeting_type');
        $date = $request->input('date');

        $patientMeetings = PatientMeeting::with([
            'patient:id,patient_name,patient_code,patient_photo',
            'specialist:id,name,designation,photo',
        ])
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")

                        ->orWhereHas('patient', function ($q2) use ($search) {

                            $q2->where(
                                'patient_name',
                                'like',
                                "%{$search}%"
                            )
                                ->orWhere(
                                    'patient_code',
                                    'like',
                                    "%{$search}%"
                                );
                        })

                        ->orWhereHas('specialist', function ($q2) use ($search) {

                            $q2->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
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

            ->get();


        return view(
            'backend.patient_management.patient_meetings.patient_list',
            compact(
                'patientMeetings',
                'search',
                'status',
                'meetingType',
                'date'
            )
        );
    }

    public function today(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $today = now()->toDateString();

        $patientMeetings = PatientMeeting::with([
            'patient:id,patient_name,patient_code,patient_photo',
            'specialist:id,name,designation,photo',
        ])

            ->whereDate('meeting_date', $today)

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%")

                        ->orWhereHas(
                            'patient',
                            fn($qq) =>
                            $qq->where(
                                'patient_name',
                                'like',
                                "%{$search}%"
                            )
                                ->orWhere(
                                    'patient_code',
                                    'like',
                                    "%{$search}%"
                                )
                        )

                        ->orWhereHas(
                            'specialist',
                            fn($qq) =>
                            $qq->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )
                        );
                });
            })

            ->when($status, function ($query) use ($status) {

                $query->where('status', $status);
            })

            ->orderBy('start_time')

            ->paginate(15)

            ->withQueryString();

        $completedCount = PatientMeeting::whereDate(
            'meeting_date',
            $today
        )
            ->where('status', 'completed')
            ->count();

        $pendingCount = PatientMeeting::whereDate(
            'meeting_date',
            $today
        )
            ->where('status', 'pending')
            ->count();

        $cancelledCount = PatientMeeting::whereDate(
            'meeting_date',
            $today
        )
            ->where('status', 'cancelled')
            ->count();

        return view(
            'backend.patient_management.patient_meetings.patient_today',
            compact(
                'patientMeetings',
                'search',
                'status',
                'completedCount',
                'pendingCount',
                'cancelledCount'
            )
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
    public function show(PatientMeeting $patientMeeting)
    {
        $patientMeeting->load([
            'patient',
            'specialist',
        ]);

        $viewData = $this->prepareMeetingViewData($patientMeeting);

        return view(
            'backend.patient_management.patient_meetings.show',
            $viewData
        );
    }

    /**
     * Prepare data for meeting show page.
     */
    private function prepareMeetingViewData(PatientMeeting $patientMeeting): array
    {
        $patient = $patientMeeting->patient;
        $specialist = $patientMeeting->specialist;

        return [
            'patientMeeting' => $patientMeeting,

            'meetingTitle' => $patientMeeting->title
                ?? ucfirst(str_replace('_', ' ', $patientMeeting->meeting_type)),

            'meetingStatus' => ucfirst($patientMeeting->status),

            'meetingType' => ucfirst(
                str_replace('_', ' ', $patientMeeting->meeting_type)
            ),

            'patient' => $patient,

            'specialist' => $specialist,

            'patientImage' => (
                $patient &&
                $patient->patient_photo &&
                file_exists(public_path($patient->patient_photo))
            )
                ? asset($patient->patient_photo)
                : asset('uploads/images/default.jpg'),
        ];
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
