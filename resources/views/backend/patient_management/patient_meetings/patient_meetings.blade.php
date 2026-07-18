@extends('adminlte::page')

@section('title', 'Specialist Patient History')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-user-md text-primary mr-2"></i>
                Specialist Patient History
            </h1>

            <small class="text-muted">
                Patient meeting overview of Dr. {{ $specialist->name }}
            </small>

        </div>

        <a href="{{ route('specialists.show', $specialist->id) }}" class="btn btn-outline-primary">

            <i class="fas fa-user-md mr-1"></i>
            Specialist Profile

        </a>

    </div>

@stop

@section('content')

    @php

        $today = \Carbon\Carbon::today();

        $recent = $specialist->meetings
            ->filter(fn($m) => optional($m->meeting_date)->isSameDay($today))
            ->unique('patient_id');

        $yesterday = $specialist->meetings
            ->filter(fn($m) => optional($m->meeting_date)->isSameDay($today->copy()->subDay()))
            ->unique('patient_id');

        $dayBefore = $specialist->meetings
            ->filter(fn($m) => optional($m->meeting_date)->isSameDay($today->copy()->subDays(2)))
            ->unique('patient_id');

        $week = $specialist->meetings
            ->filter(fn($m) => optional($m->meeting_date)->isCurrentWeek())
            ->unique('patient_id');

        $month = $specialist->meetings
            ->filter(fn($m) => optional($m->meeting_date)->isCurrentMonth())
            ->unique('patient_id');

    @endphp


    {{-- Specialist Header --}}
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="d-flex align-items-center">

                @php

                    $doctorImage = $specialist->photo
                        ? asset('uploads/images/welcome_page/doctors/' . $specialist->photo)
                        : asset('uploads/images/default.jpg');

                @endphp

                <img src="{{ $doctorImage }}" class="rounded-circle shadow-sm mr-4"
                    style="
                        width:120px;
                        height:120px;
                        object-fit:cover;
                        border:5px solid #fff;
                    ">

                <div>

                    <h3 class="mb-1">

                        Dr. {{ $specialist->name }}

                    </h3>

                    <div class="text-muted mb-2">

                        {{ $specialist->designation }}

                    </div>

                    @if ($specialist->degree)
                        <div class="text-muted">

                            {{ $specialist->degree }}

                        </div>
                    @endif

                    <div class="mt-3">

                        <span class="badge badge-primary p-2">

                            {{ $specialist->meetings->count() }}
                            Total Meetings

                        </span>

                        <span class="badge badge-success p-2 ml-2">

                            {{ $specialist->meetings->pluck('patient_id')->unique()->count() }}
                            Total Patients

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    @foreach ([
            'Recent' => $recent,
            'Yesterday' => $yesterday,
            'Day Before' => $dayBefore,
            'This Week' => $week,
            'This Month' => $month,
        ] as $title => $meetings)
        <div class="card card-outline card-primary shadow-sm mt-4">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">

                        <i class="fas fa-calendar-check mr-2 text-primary"></i>

                        {{ $title }}

                    </h5>

                    <span class="badge badge-primary">

                        {{ $meetings->count() }}
                        Patients

                    </span>

                </div>

            </div>

            <div class="card-body">

                @if ($meetings->count())
                    <div class="row">

                        @foreach ($meetings as $meeting)
                            @php

                                $patient = $meeting->patient;

                                $patientImage =
                                    $patient &&
                                    $patient->patient_photo &&
                                    file_exists(public_path($patient->patient_photo))
                                        ? asset($patient->patient_photo)
                                        : asset('uploads/images/default.jpg');

                            @endphp

                            <div class="col-xl-4 col-lg-6 mb-4">

                                <div class="card patient-history-card h-100">

                                    <div class="card-body">

                                        <div class="d-flex">

                                            <div class="mr-3">

                                                <img src="{{ $patientImage }}" class="rounded-circle shadow-sm"
                                                    style="
                                                        width:75px;
                                                        height:75px;
                                                        object-fit:cover;
                                                    ">
                                            </div>

                                            <div class="flex-grow-1">

                                                <h5 class="mb-1">

                                                    {{ $patient?->patient_name ?? 'General Meeting' }}

                                                </h5>

                                                <div class="text-muted">

                                                    {{ $patient?->patient_code }}

                                                </div>

                                                <div class="mt-2">

                                                    <span class="badge badge-light">

                                                        <i class="far fa-calendar mr-1"></i>

                                                        {{ $meeting->meeting_date?->format('d M Y') }}

                                                    </span>

                                                </div>

                                                <div class="mt-2">

                                                    <span class="badge badge-light">

                                                        <i class="far fa-clock mr-1"></i>

                                                        {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') : '--' }}

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                        <hr>

                                        <div class="small text-muted mb-3">

                                            {{ \Illuminate\Support\Str::limit(
                                                $meeting->description ?? ($meeting->notes ?? ($patient?->patient_problem_description ?? 'No Description')),
                                                110,
                                            ) }}

                                        </div>

                                        <div class="d-flex justify-content-between">

                                            @if ($patient)
                                                <a href="{{ route('patients.show', $patient->id) }}"
                                                    class="btn btn-outline-primary btn-sm">

                                                    <i class="fas fa-user mr-1"></i>

                                                    Patient

                                                </a>
                                            @endif


                                            <a href="{{ route('patient_meetings.show', $meeting->id) }}"
                                                class="btn btn-primary btn-sm">

                                                <i class="fas fa-eye mr-1"></i>

                                                Meeting

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="text-center py-5">

                        <i class="far fa-folder-open fa-4x text-muted mb-3"></i>

                        <h5 class="text-muted">

                            No Patients Found

                        </h5>

                    </div>
                @endif

            </div>

        </div>
    @endforeach

@stop


@section('css')

    <style>
        .patient-history-card {
            border: none;
            border-radius: 18px;
            transition: .3s;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
        }

        .patient-history-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .12);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f3f5;
        }

        .badge-light {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: .5rem .75rem;
            font-size: .75rem;
        }
    </style>

@endsection
