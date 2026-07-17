<div class="patient-card-wrapper">

    @forelse($meetings->take(3) as $meeting)
        <div class="patient-mini-card">

            <div class="patient-name">

                {{ $meeting->patient?->patient_name ?? 'General Meeting' }}

            </div>

            <div class="patient-desc">

                {{ \Illuminate\Support\Str::limit(
                    $meeting->description ?? ($meeting->notes ?? ($meeting->patient?->patient_problem_description ?? 'No Description')),
                    55,
                ) }}

            </div>

            <div class="patient-time">

                <i class="far fa-clock"></i>

                {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') : '--' }}

            </div>

            <div class="mt-1">

                <small class="text-muted">

                    {{ $meeting->meeting_date ? $meeting->meeting_date->format('d M Y') : '' }}

                </small>

            </div>

        </div>

    @empty

        <div class="patient-empty">
            No Meeting
        </div>
    @endforelse

</div>
