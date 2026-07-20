@php

    if ($patient->location_type == 1) {
        $location = $patient->location_simple;
    } elseif ($patient->location_type == 2) {
        $location = collect([$patient->house_address, $patient->city, $patient->district])
            ->filter()
            ->implode(', ');

        if ($patient->post_code) {
            $location .= ' - ' . $patient->post_code;
        }
    } else {
        $location = collect([$patient->country, $patient->passport_no ? 'Passport: ' . $patient->passport_no : null])
            ->filter()
            ->implode(' | ');
    }

@endphp


<div class="location-card">

    <div class="location-icon">

        <i class="fas fa-map-marker-alt"></i>

    </div>

    <div>

        <small class="text-muted d-block mb-1">
            Registered Location
        </small>

        <strong>
            {{ $location ?: 'N/A' }}
        </strong>

    </div>

</div>
