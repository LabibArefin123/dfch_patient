{{-- ========================= FRONT SIDE ========================= --}}
<div class="doctor-card">
    <div class="card-top-bg"></div>
    <div class="card-wave"></div>

    {{-- Doctor Photo --}}
    <div class="photo-wrapper">
        <div class="photo-ring">
            <img src="{{ asset('uploads/images/welcome_page/doctors/' . $specialistCard->specialist->photo) }}"
                alt="{{ $specialistCard->specialist->name }}">
        </div>
    </div>


    {{-- Doctor Information --}}
    <div class="doctor-info">
        <h2>{{ $specialistCard->specialist->name }}</h2>
        @if ($specialistCard->show_designation)
            <h5>
                {{ $specialistCard->specialist->designation }}
            </h5>
        @endif

        @if ($specialistCard->show_degree)
            <p class="doctor-degree">
                {{ $specialistCard->specialist->degree }}
            </p>
        @endif
    </div>

    {{-- Doctor Contact Information --}}
    <div class="card-body-info">
        <div class="info-card">
            {{-- Hospital Logo --}}
            @if ($specialistCard->show_logo)
                <div class="logo-card">
                    <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
                </div>
            @endif
        </div>
    </div>
</div>
