<div class="doctor-card-holder">
    <div class="lanyard-hole"></div>
    <div class="doctor-card">
        <div class="card-top-bg"></div>
        <div class="card-wave"></div>
        @if ($card->show_logo)
            <div class="hospital-logo">
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
            </div>
        @endif
    
        <div class="photo-wrapper">
            <div class="photo-ring">
                <img src="{{ asset('uploads/images/welcome_page/doctors/' . $card->specialist->photo) }}"
                    alt="{{ $card->specialist->name }}">
            </div>
        </div>

        <div class="doctor-info">
            <h2>{{ $card->specialist->name }} </h2>
            @if ($card->show_designation)
                <h5>{{ $card->specialist->designation }}</h5>
            @endif

            @if ($card->show_degree)
                <p class="doctor-degree">{{ $card->specialist->degree }}</p>
            @endif
        </div>

        <div class="card-body-info">
            <div class="info-row">
                <div class="info-title">
                    Doctor ID
                </div>

                <div class="info-value">
                    DFCH-{{ str_pad($card->specialist->id, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="info-row">
                <div class="info-title">
                    Join Date
                </div>

                <div class="info-value">
                    {{ optional($card->specialist->created_at)->format('d-m-Y') }}
                </div>
            </div>

            <div class="info-row">
                <div class="info-title">
                    Phone
                </div>

                <div class="info-value">
                    {{ $card->specialist->phone ?? '+880 1XXXXXXXXX' }}
                </div>
            </div>

            <div class="barcode-section">
                <div class="barcode-line">
                    {!! DNS1D::getBarcodeHTML('DFCH-' . $card->specialist->id, 'C128', 2, 45) !!}
                </div>
            </div>

        </div> {{-- doctor-card --}}

        {{-- ========================= BACK SIDE ========================= --}}


        <div class="doctor-card-back">


            <div class="back-top-bg"></div>


            <div class="back-hospital-logo">

                @if ($card->show_logo)
                    <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
                @endif

            </div>


            <div class="back-hospital-name">

                <h3>

                    {{ config('app.name', 'DFCH') }}

                </h3>

                <p>

                    COLORECTAL HOSPITAL

                </p>

            </div>



            <div class="back-content">


             
                <div class="back-divider"></div>



                @if ($card->show_contact)
                    <h4>

                        Contact Us:

                    </h4>


                    <div class="contact-details">


                        <p>

                            <i class="fas fa-phone"></i>

                            {{ $card->specialist->phone ?? '+880 1XXXXXXXXX' }}

                        </p>


                        <p>

                            <i class="fas fa-envelope"></i>

                            {{ $card->specialist->email ?? 'info@hospital.com' }}

                        </p>


                        <p>

                            <i class="fas fa-map-marker-alt"></i>

                            {{ $card->address ?? 'Hospital Address Here' }}

                        </p>


                    </div>
                @endif



            </div>



            @if ($card->show_signature)
                <div class="doctor-signature">


                    <img src="{{ asset('uploads/images/signature/' . $card->specialist->signature) }}" alt="Signature">


                    <p>

                        Authorized Signature

                    </p>


                </div>
            @endif



            <div class="back-bottom-wave"></div>


        </div>


    </div>
</div>
