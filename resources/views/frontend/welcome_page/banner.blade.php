<section id="banner" class="bg-white w-100">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom_banner.css') }}">

    <div id="slider" class="position-relative w-100" style="height:70vh;">
        @php
            $slides = [
                [
                    'image' => 'image_1.png',
                    'align' => 'right',
                    'name' => 'Prof. Dr. AKM Fazlul Haque',
                    'designation' => 'Fellow, Colorectal Surgery (Singapore)',
                    'details' => 'International Scholar, Colorectal Surgery (USA)<br>
                        Founder Chairman (RETD), Department of Colorectal Surgery<br>
                        Bangladesh Medical University, Dhaka<br>
                        <strong>25 Years of Dedicated Service</strong>',
                    'route' => route('doc_1'),
                ],
                [
                    'image' => 'image_2.png',
                    'align' => 'left',
                    'name' => 'Dr. Asif Almas Haque',
                    'designation' => 'MBBS (SSMC), MRCS (ENG)',
                    'details' => 'FCPS (Surgery), FCPS (Colorectal Surgery), FRCS (ENG)<br>
                        Fellow of American College of Surgeons (FACS)<br>
                        Fellow of American Society of Colon & Rectal Surgeons (FASCRS)',
                    'route' => route('doc_2'),
                ],
            ];
        @endphp

        {{-- Slides --}}
        @foreach ($slides as $index => $slide)
            <div class="slide {{ $index === 0 ? 'active' : '' }}" data-route="{{ $slide['route'] }}"
                style="position:absolute; inset:0;">

                <div class="doctor-slide h-100">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">

                            {{-- Image (Left) --}}
                            @if ($slide['align'] === 'left')
                                <div class="col-md-6 h-100 position-relative order-1 order-md-0">
                                    <a href="{{ $slide['route'] }}" class="doctor-image-link">
                                        <img src="{{ asset('uploads/images/welcome_page/slider/' . $slide['image']) }}"
                                            class="doctor-img left" alt="{{ $slide['name'] }}">
                                    </a>
                                </div>
                            @endif


                            {{-- Text Content --}}
                            <div class="col-md-6 text-white z-2">
                                <h2 class="fw-bold display-6 mb-2">{{ $slide['name'] }}</h2>
                                <p class="fs-5 mb-2">{{ $slide['designation'] }}</p>
                                <p class="lh-lg opacity-90">{!! $slide['details'] !!}</p>
                            </div>

                            {{-- Image (Right) --}}
                            @if ($slide['align'] === 'right')
                                <div class="col-md-6 h-100 position-relative">
                                    <a href="{{ $slide['route'] }}" class="doctor-image-link">
                                        <img src="{{ asset('uploads/images/welcome_page/slider/' . $slide['image']) }}"
                                            class="doctor-img right" alt="{{ $slide['name'] }}">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Dots --}}
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-3 d-flex gap-2">
            @foreach ($slides as $i => $slide)
                <span class="dot" onclick="goToSlide({{ $i }})"></span>
            @endforeach
        </div>

    </div>
</section>
