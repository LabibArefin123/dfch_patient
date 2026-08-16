<div class="card card-outline card-primary shadow meeting-dashboard">
    <div class="card-header meeting-dashboard-header">
        <div class="meeting-dashboard-heading">
            <div class="meeting-dashboard-title">
                <i class="fas fa-calendar-week"></i>
                <div>
                    <h3>Meeting Dashboard</h3>
                    <div class="meeting-dashboard-subtitle">
                        Specialist wise patient meeting overview
                    </div>
                </div>
            </div>
        </div>

        <div class="meeting-dashboard-actions">
            <button type="button" id="meetingViewToggle" class="meeting-view-toggle" data-view="summary">
                <i class="fas fa-table"></i>
                <span>Date Wise</span>
            </button>

            <span class="meeting-count-badge">
                <strong>{{ $patientMeetings->total() }}</strong>
                <span>Meetings</span>
            </span>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive dashboard-table-wrapper">
            <table class="table table-bordered table-hover meeting-grid mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:80px;">SL</th>
                        <th style="min-width:250px;">Specialist</th>
                        <th class="summary-col d-none" style="min-width:700px;">Recent Patients</th>
                        <th style="min-width:280px;" class="date-wise-col">Recent</th>
                        <th style="min-width:280px;" class="date-wise-col">Yesterday</th>
                        <th style="min-width:280px;" class="date-wise-col">Day Before Yesterday</th>
                        <th style="min-width:280px;" class="date-wise-col">This Week</th>
                        <th style="min-width:280px;" class="date-wise-col">This Month</th>
                        <th class="text-center" style="min-width:235px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($specialists as $specialist)
                        <tr>
                            <td class="text-center align-middle">
                                <strong>{{ $loop->iteration }}</strong>
                            </td>
                            <td>
                                <div class="specialist-box">
                                    <div class="specialist-avatar">
                                        @if ($specialist->doctor_image)
                                            <img src="{{ $specialist->doctor_image }}" alt="{{ $specialist->name }}"
                                                class="specialist-image" loading="lazy">
                                        @else
                                            <span>{{ $specialist->doctor_initial }}</span>
                                        @endif
                                    </div>
                                    <div class="specialist-info">
                                        <h6 class="mb-1">{{ $specialist->name }}</h6>
                                        <p class="mb-1">{{ $specialist->designation }}</p>
                                        @if ($specialist->degree)
                                            <small class="text-muted">{{ $specialist->degree }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="summary-col d-none">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.summary_patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['meetings'],
                                        'specialist' => $specialist,
                                    ]
                                )
                            </td>
                            <td class="date-wise-col">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['recent'],
                                    ]
                                )
                            </td>
                            <td class="date-wise-col">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['yesterday'],
                                    ]
                                )
                            </td>
                            <td class="date-wise-col">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['day_before'],
                                    ]
                                )
                            </td>
                            <td class="date-wise-col">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['week'],
                                    ]
                                )
                            </td>
                            <td class="date-wise-col">
                                @include(
                                    'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                    [
                                        'meetings' => $specialist->meeting_summary['month'],
                                    ]
                                )
                            </td>
                            <td class="text-center">
                                <a href="{{ route('patient_meetings.show', $specialist->id) }}"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-eye mr-1"></i>Per Patient Detail
                                </a>
                                <a href="{{ route('specialists.show', $specialist->id) }}"
                                    class="btn btn-sm btn-outline-warning mb-2">
                                    <i class="fas fa-user-md mr-1"></i>Specialist Detail
                                </a>
                                <a href="{{ route('patient_meetings.history', $specialist->id) }}"
                                    class="btn btn-sm btn-outline-secondary mb-2">
                                    <i class="fas fa-users mr-1"></i>Specialist Patients History
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <span class="text-muted">No specialists found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-end">
            {{ $specialists->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
