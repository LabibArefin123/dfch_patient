{{-- ========================= CARD DESIGN 3 ========================= --}}
<div class="doctor-card-3">

    {{-- Decorative Red Shapes --}}
    <div class="card-3-shape-top"></div>
    <div class="card-3-shape-circle"></div>
    <div class="card-3-shape-bottom"></div>

    {{-- Hospital Logo --}}
    @if ($specialistCard->show_logo)
        <div class="card-3-logo">
            <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
        </div>
    @endif

    {{-- Doctor Photo --}}
    <div class="card-3-photo-wrapper">
        <div class="card-3-photo-ring">
            <img src="{{ asset('uploads/images/welcome_page/doctors/' . $specialistCard->specialist->photo) }}"
                alt="{{ $specialistCard->specialist->name }}">
        </div>
    </div>

    {{-- Doctor Information --}}
    <div class="card-3-doctor-info">

        <h2>
            {{ $specialistCard->specialist->name }}
        </h2>

        @if ($specialistCard->show_designation)
            <h5>
                {{ $specialistCard->specialist->designation }}
            </h5>
        @endif

        @if ($specialistCard->show_degree)
            <p>
                {{ $specialistCard->specialist->degree }}
            </p>
        @endif

    </div>
</div>
