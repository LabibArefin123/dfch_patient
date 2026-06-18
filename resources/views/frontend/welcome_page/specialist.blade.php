<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_preview.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_preview_hover.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_trip.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_trip_hover.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_doctor_list.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_doctor_item.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/specialist_section/specialist_animations.css') }}">
<section id="specialists" class="py-5">
    <div class="container">

        <!-- SECTION HEADER -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Medical Specialists</h2>
            <p class="text-muted fs-5">
                Experienced hands, compassionate care, and excellence in colorectal health.
            </p>
        </div>

        <div class="row align-items-center">

            <!-- LEFT : IMAGE SLIDER -->
            <div class="col-lg-5 position-relative specialist-left">
                @php
                    $doctors = [
                        [
                            'image' => 'image_1.jpg',
                            'name' => 'Prof. Dr. AKM Fazlul Haque',
                            'degree' => 'MBBS, FCPS, FICS',
                            'details' => 'Fellow, Colorectal Surgery (Singapore), International Scholar (USA)<br>
                                 Founder Chairman (RETD.), Department of Colorectal Surgery<br>
                                 Bangladesh Medical University, Dhaka<br>
                                 Chief Consultant, DFCH',
                            'route' => route('doc_1'),
                        ],
                        [
                            'image' => 'image_2.jpg',
                            'name' => 'Dr. Asif Almas Haque',
                            'degree' => 'MBBS, FCPS, FRCS, FACS, FASCRS',
                            'details' => 'Consultant, Colorectal, Laparoscopic & Laser Surgeon<br>
                                 Member, American Society of Colon & Rectal Surgeons',
                            'route' => route('doc_2'),
                        ],
                        [
                            'image' => 'image_3.jpg',
                            'name' => 'Dr. Fatema Sharmin (Anny)',
                            'degree' => 'MBBS, DA, FCPS (Final)',
                            'details' => 'Consultant (Anesthesiology), DFCH<br>
                                 Assistant Professor, Bangladesh Medical College Hospital',
                            'route' => route('doc_3'),
                        ],
                        [
                            'image' => 'image_4.jpg',
                            'name' => 'Dr. Sakib Sarwat Haque',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                            'route' => route('doc_4'),
                        ],
                        [
                            'image' => 'image_5.jpg',
                            'name' => 'Dr. Asma Husain Noora',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                            'route' => route('doc_5'),
                        ],
                    ];
                @endphp

                <!-- BIG PREVIEW -->
                <div class="spec-preview">
                    <div class="preview-wrap">
                        <a id="doctorLink" href="{{ $doctors[0]['route'] }}">
                            <img id="previewImg"
                                src="{{ asset('uploads/images/welcome_page/doctors/' . $doctors[0]['image']) }}">
                            <div class="preview-hover">View More</div>
                        </a>
                    </div>
                </div>

                <!-- THUMB STRIP -->
                <div class="spec-strip">
                    @foreach ($doctors as $i => $doc)
                        <a href="#" class="strip-item {{ $i === 0 ? 'active' : '' }}"
                            data-index="{{ $i }}">
                            <img src="{{ asset('uploads/images/welcome_page/doctors/' . $doc['image']) }}"
                                alt="{{ $doc['name'] }}">
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT : INFO -->
            <div class="col-lg-7">
                <div class="row">

                    <!-- LEFT: Doctor Info -->
                    <div class="col-md-8">
                        <div id="spec-info">
                            <h3 class="fw-bold" id="docName">{{ $doctors[0]['name'] }}</h3>
                            <p class="text-danger fw-semibold" id="docDegree">{{ $doctors[0]['degree'] }}</p>
                            <p class="lh-lg" id="docDetails">{!! $doctors[0]['details'] !!}</p>
                        </div>
                    </div>

                    <!-- RIGHT: Vertical Doctor List -->
                    <div class="col-md-4">
                        <p>Doctor List</p>
                        <div class="doctor-list">

                            @foreach ($doctors as $i => $doc)
                                <div class="doctor-item {{ $i === 0 ? 'active' : '' }}"
                                    data-index="{{ $i }}">

                                    <img src="{{ asset('uploads/images/welcome_page/doctors/' . $doc['image']) }}"
                                        alt="{{ $doc['name'] }}">

                                    <span>{{ $doc['name'] }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<script>
    const doctors = @json($doctors);

    const doctorImageBasePath =
        "{{ asset('uploads/images/welcome_page/doctors') }}";
</script>
<script src="{{ asset('js/custom_frontend/welcome_page/specialist_section/specialist_config.js') }}"></script>
<script src="{{ asset('js/custom_frontend/welcome_page/specialist_section/specialist_slider.js') }}"></script>
<script src="{{ asset('js/custom_frontend/welcome_page/specialist_section/specialist_events.js') }}"></script>
