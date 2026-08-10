{{-- ========================= BACK SIDE - CARD DESIGN 3 ========================= --}}
<div class="doctor-card-back-3">
    {{--  TOP RED DECORATION --}}
    <div class="back-3-top-shape"></div>
    <div class="back-3-top-line"></div>


    {{-- HOSPITAL LOGO--}}
    @if ($specialistCard->show_logo)
        <div class="back-3-logo">
            <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
        </div>
    @endif


    {{-- CARD TITLE--}}
    <div class="back-3-title">
        <span class="back-3-title-icon">
            <i class="fas fa-id-card"></i>
        </span>

        <div>
            <h3>IDENTIFICATION CARD</h3>
            <p>AUTHORIZED SPECIALIST</p>
        </div>
    </div>

    {{-- SPECIALIST INFORMATION BOX--}}
    <div class="back-3-profile-box">

        <div class="back-3-profile-icon">
            <i class="fas fa-user-md"></i>
        </div>

        <div class="back-3-profile-content">
            <span class="back-3-label"> CARD HOLDER </span>
            <strong>{{ $specialistCard->specialist->name }} </strong>
            @if ($specialistCard->show_designation)
                <small> {{ $specialistCard->specialist->designation }} </small>
            @endif
        </div>
    </div>

    {{--  IMPORTANT INFORMATION--}}
    <div class="back-3-information">
        <div class="back-3-section-heading">
            <span></span>
            <h4>IMPORTANT INFORMATION</h4>
            <span></span>
        </div>


        <div class="back-3-instruction">

            <div class="back-3-instruction-icon">
                <i class="fas fa-check"></i>
            </div>

            <p>
                This identification card is the official property of the hospital.
            </p>

        </div>


        <div class="back-3-instruction">

            <div class="back-3-instruction-icon">
                <i class="fas fa-check"></i>
            </div>

            <p>
                The card must be carried and displayed while on hospital duty.
            </p>

        </div>


        <div class="back-3-instruction">

            <div class="back-3-instruction-icon">
                <i class="fas fa-check"></i>
            </div>

            <p>
                This card is non-transferable and may only be used by the assigned specialist.
            </p>

        </div>


        <div class="back-3-instruction">

            <div class="back-3-instruction-icon">
                <i class="fas fa-check"></i>
            </div>

            <p>
                Report immediately to administration if the card is lost or damaged.
            </p>

        </div>

    </div>


    {{-- =========================================================
         RED SECURITY SEAL
    ========================================================== --}}
    <div class="back-3-seal">

        <div class="back-3-seal-inner">
            <i class="fas fa-shield-alt"></i>
            <span>OFFICIAL</span>
            <small>ID CARD</small>
        </div>

    </div>


    {{-- =========================================================
         WEBSITE / CONTACT
    ========================================================== --}}
    <div class="back-3-footer">

        <div class="back-3-footer-item">
            <i class="fas fa-globe"></i>
            <span>fazlulhaquehospital.labib.work</span>
        </div>

        <div class="back-3-footer-divider"></div>

        <div class="back-3-footer-item">
            <i class="fas fa-id-badge"></i>
            <span>AUTHORIZED STAFF</span>
        </div>

    </div>


    {{-- =========================================================
         BOTTOM DECORATION
    ========================================================== --}}
    <div class="back-3-bottom-shape"></div>

</div>
