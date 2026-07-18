@php
    $chunks = $meetings->values()->chunk(3);
@endphp

@if ($chunks->count())

    <div class="summary-slider">

        @foreach ($chunks as $index => $meetingsChunk)
            <div class="summary-page {{ $index === 0 ? 'active' : '' }}">

                <div class="row g-3">

                    @foreach ($meetingsChunk as $meeting)
                        @php
                            $patient = $meeting->patient;
                            $patientName = $patient?->patient_name ?? 'Unknown Patient';
                            $initial = strtoupper(substr($patientName, 0, 1));
                        @endphp

                        <div class="col-md-4">

                            <div class="patient-summary-card">

                                {{-- Top Accent --}}
                                <div class="card-accent"></div>

                                {{-- View Button --}}
                                <a href="{{ route('patient_meetings.show', $meeting->id) }}" class="summary-eye"
                                    title="View Meeting">

                                    <i class="fas fa-arrow-up-right-from-square"></i>

                                </a>

                                <div class="patient-summary-content">

                                    {{-- Patient Photo --}}
                                    <div class="patient-photo">

                                        @if ($patient?->patient_photo)
                                            <img src="{{ asset($patient->patient_photo) }}" alt="{{ $patientName }}">
                                        @else
                                            <div class="patient-avatar">
                                                {{ $initial }}
                                            </div>
                                        @endif

                                    </div>

                                    {{-- Patient Information --}}
                                    <div class="patient-info">

                                        <h6 class="patient-name">

                                            {{ $patientName }}

                                        </h6>

                                        <div class="patient-code">

                                            <i class="fas fa-id-card"></i>

                                            {{ $patient?->patient_code ?? 'N/A' }}

                                        </div>

                                        <div class="meeting-date">

                                            <i class="far fa-calendar-alt"></i>

                                            {{ $meeting->meeting_date?->format('d M Y') ?? 'Date unavailable' }}

                                        </div>

                                    </div>

                                </div>

                                {{-- Meeting Label --}}
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

    {{-- Pagination --}}
    @if ($chunks->count() > 1)

        <div class="summary-pagination">

            <div class="pagination-label">

                <i class="fas fa-layer-group"></i>

                Meeting Pages

            </div>

            <div class="pagination-buttons">

                @foreach ($chunks as $index => $item)
                    <button type="button" class="summary-dot {{ $index === 0 ? 'active' : '' }}"
                        data-page="{{ $index }}">

                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

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
