@php

    $medicalSections = [
        [
            'title' => 'Patient Problem',
            'icon' => 'fa-heartbeat',
            'content' => $patient->patient_problem_description,
        ],

        [
            'title' => 'Drug Information',
            'icon' => 'fa-pills',
            'content' => $patient->patient_drug_description,
        ],

        [
            'title' => 'Remarks',
            'icon' => 'fa-comment-medical',
            'content' => $patient->remarks,
        ],
    ];

@endphp


@foreach ($medicalSections as $section)
    <div class="medical-information-block">

        <div class="medical-information-title">

            <i class="fas {{ $section['icon'] }} mr-2"></i>

            {{ $section['title'] }}

        </div>

        <div class="medical-information-content">

            {!! $section['content'] ?: '<span class="text-muted">No information provided</span>' !!}

        </div>

    </div>
@endforeach
