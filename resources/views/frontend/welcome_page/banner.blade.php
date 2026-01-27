<section id="banner" class="py-5 bg-white">
    <div class="container">
        <div id="slider" class="position-relative" style="height: 70vh;">
            <!-- Slides -->
            @php
                $slides = [
                    [
                        'type' => 'doctor',
                        'align' => 'right',
                        'image' => 'image_1.png',
                        'name' => 'Prof. Dr. AKM Fazlul Haque',
                        'designation' => 'Fellow, Colorectal Surgery (Singapore)',
                        'extra' => 'International Scholar, Colorectal Surgery (USA)<br>
                        Founder Chairman (RETD), Department of Colorectal Surgery<br>
                        Bangladesh Medical University, Dhaka<br>
                        <strong>25 Years of Dedicated Service in Colon & Rectal Surgery</strong>',
                    ],
                    [
                        'type' => 'doctor',
                        'align' => 'left',
                        'image' => 'image_2.png',
                        'name' => 'Dr. Asif Almas Haque',
                        'designation' => 'MBBS (SSMC), MRCS (ENG)',
                        'extra' => 'FCPS (Surgery), FCPS (Colorectal Surgery), FRCS (ENG)<br>
                        Fellow of American College of Surgeons (FACS)<br>
                        Fellow of American Society of Colon & Rectal Surgeons (FASCRS)',
                    ],
                ];
            @endphp

            @foreach ($slides as $index => $slide)
                <div class="slide {{ $index === 0 ? 'active' : '' }} position-absolute top-0 start-0 w-100 h-100">

                    {{-- DOCTOR PROFILE SLIDE --}}
                    @if ($slide['type'] === 'doctor')
                        <div class="doctor-slide h-100">
                            <div class="container h-100">
                                <div class="row h-100 align-items-center">

                                    {{-- IMAGE LEFT --}}
                                    @if ($slide['align'] === 'left')
                                        <div class="col-md-6 position-relative h-100 order-1 order-md-0">
                                            <img src="{{ asset('uploads/images/welcome_page/slider/' . $slide['image']) }}"
                                                class="doctor-img left" alt="{{ $slide['name'] }}">
                                        </div>
                                    @endif

                                    {{-- CONTENT --}}
                                    <div class="col-md-6 text-white z-2">
                                        <h2 class="fw-bold display-6 mb-1">{{ $slide['name'] }}</h2>
                                        <p class="fs-5  mb-2">{{ $slide['designation'] }}</p>
                                        <p class="opacity-90 lh-lg">{!! $slide['extra'] !!}</p>
                                    </div>

                                    {{-- IMAGE RIGHT --}}
                                    @if ($slide['align'] === 'right')
                                        <div class="col-md-6 position-relative h-100">
                                            <img src="{{ asset('uploads/images/welcome_page/slider/' . $slide['image']) }}"
                                                class="doctor-img right" alt="{{ $slide['name'] }}">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Navigation Arrows -->
            <button onclick="prevSlide()" class="arrow-btn start">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="arrow-btn end">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Dots -->
            <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-3 d-flex gap-2">
                @foreach ($slides as $i => $slide)
                    <span class="dot" onclick="goToSlide({{ $i }})"></span>
                @endforeach
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="{{ asset('css/custom_banner.css') }}">

<script>
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll("#slider .slide");
    const dots = document.querySelectorAll("#slider .dot");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
        });

        currentSlideIndex = index;
    }

    function nextSlide() {
        const nextIndex = (currentSlideIndex + 1) % slides.length;
        showSlide(nextIndex);
    }

    function prevSlide() {
        const prevIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
        showSlide(prevIndex);
    }

    function goToSlide(index) {
        showSlide(index);
    }

    setInterval(nextSlide, 15000);
    showSlide(currentSlideIndex);
</script>
