<div class="wide-card mt-4">
    {{-- ========================= FRONT SIDE - WIDE CARD ========================= --}}
    <div class="wide-header">
        <div class="wide-header-logo">
            <img src="{{ asset('uploads/images/icon.png') }}" alt="Hospital Logo">
        </div>

        <div class="wide-header-title">
            <h4>Dr. Fazlul Haque Colorectal Hospital Limited</h4>
            <p>SPECIALIST ID CARD</p>
        </div>

    </div>

    <div class="wide-wave"></div>

    <div class="wide-photo">
        <div class="wide-photo-frame">
            <img src="{{ asset('uploads/images/welcome_page/doctors/' . $specialistCard->specialist->photo) }}"
                alt="{{ $specialistCard->specialist->name }}">
        </div>
    </div>

    <div class="wide-content">
        <h2 class="wide-name"> {{ $specialistCard->specialist->name }}</h2>
        @if ($specialistCard->show_designation)
            <div class="wide-designation"> {{ $specialistCard->specialist->designation }} </div>
        @endif

        @if ($specialistCard->show_degree)
            <div class="wide-degree">{{ $specialistCard->specialist->degree }}</div>
        @endif
    </div>

    <div class="wide-footer">
        <div class="wide-footer-left">
            <i class="fas fa-id-badge"></i>
            Official Hospital Identity Card
        </div>

        @if ($specialistCard->show_logo)
            <div class="wide-footer-logo">
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
            </div>
        @endif
    </div>
</div>
