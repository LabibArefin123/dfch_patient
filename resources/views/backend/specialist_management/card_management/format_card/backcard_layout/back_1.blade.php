<div class="doctor-card-holder">
    <div class="doctor-card-back">
        <div class="back-top-bg"></div>
        @if ($specialistCard->show_logo)
            <div class="back-hospital-logo">
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
            </div>
        @endif

        <div class="back-content">
            <h4>Important Instructions</h4>

            <ul class="instruction-list">
                <li>This ID card is the official property of the hospital.</li>
                <li>Carry this card and display it while on hospital duty.</li>
                <li>This card is non-transferable and may be used only by the assigned specialist.</li>
                <li>Report immediately to the administration if the card is lost, stolen, or damaged.</li>
                <li>Return this ID card to the hospital upon resignation, retirement, or termination.</li>
            </ul>

        </div>

        <div class="back-website">
            <i class="fas fa-globe"></i>
            fazlulhaquehospital.labib.work
        </div>

        <div class="back-bottom-wave"></div>

    </div>

</div>
