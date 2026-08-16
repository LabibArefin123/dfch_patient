@if ($specialist->summary_pages->count())
    <div class="summary-slider">
        @foreach ($specialist->summary_pages as $page)
            <div class="summary-page {{ $page['active'] ? 'active' : '' }}">
                <div class="row g-3">
                    @foreach ($page['meetings'] as $meeting)
                        <div class="col-md-4">
                            <div class="patient-summary-card">
                                <div class="card-accent"></div>
                                <a href="{{ route('patient_meetings.show', $meeting->id) }}" class="summary-eye"
                                    title="View Meeting">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <div class="patient-summary-content">
                                    <div class="patient-photo">
                                        @if ($meeting->summary_patient_photo)
                                            <img src="{{ $meeting->summary_patient_photo }}"
                                                alt="{{ $meeting->summary_patient_name }}">
                                        @else
                                            <div class="patient-avatar">
                                                {{ $meeting->summary_patient_initial }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="patient-info">
                                        <h6 class="patient-name">
                                            {{ $meeting->summary_patient_name }}
                                        </h6>

                                        <div class="patient-code">
                                            <i class="fas fa-id-card"></i>
                                            {{ $meeting->summary_patient_code }}
                                        </div>

                                        <div class="meeting-date">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ $meeting->summary_meeting_date }}
                                        </div>

                                        <div class="meeting-type">
                                            <i class="fas fa-stethoscope"></i>
                                            {{ $meeting->summary_meeting_type }}
                                        </div>
                                    </div>
                                </div>

                                <div class="meeting-status">
                                    <span class="status-dot"></span>
                                    Upcoming Meeting
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @if ($specialist->summary_pages->count() > 1)
        <div class="summary-pagination">
            <div class="pagination-label">
                <i class="fas fa-layer-group"></i>
                Meeting Pages
            </div>

            <div class="pagination-buttons">
                @foreach ($specialist->summary_pages as $page)
                    <button type="button" class="summary-dot {{ $page['active'] ? 'active' : '' }}"
                        data-page="{{ $page['index'] }}">
                        {{ str_pad($page['index'] + 1, 2, '0', STR_PAD_LEFT) }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif
@else
    <div class="empty-meeting-state">
        <div class="empty-icon">
            <i class="far fa-calendar-times"></i>
        </div>
        <h6>No Meetings Found</h6>
        <p>There are no upcoming patient meetings at the moment.</p>
    </div>
@endif
