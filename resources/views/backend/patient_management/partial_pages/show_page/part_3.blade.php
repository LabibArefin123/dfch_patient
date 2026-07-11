 <p class="form-control mb-2 bg-light">
     @if ($patient->location_type == 1)
         {{ $patient->location_simple }}
     @elseif ($patient->location_type == 2)
         {{ $patient->house_address }},
         {{ $patient->city }},
         {{ $patient->district }} - {{ $patient->post_code }}
     @else
         {{ $patient->country }}, Passport Number = {{ $patient->passport_no }}
         <br>
     @endif
 </p>
