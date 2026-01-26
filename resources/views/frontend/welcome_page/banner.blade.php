<section id="banner" class="py-5 bg-light">
    <div class="container">
        <div id="slider" class="position-relative rounded-4 overflow-hidden" style="height: 70vh;">
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
                                        <p class="fs-5 text-light-emphasis mb-2">{{ $slide['designation'] }}</p>
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

<style>
    #slider {
        position: relative;
    }

    .slide {
        opacity: 0;
        transition: opacity 1.2s ease-in-out;
        z-index: 1;
    }

    .slide.active {
        opacity: 1;
        z-index: 2;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.5), rgba(10, 10, 10, 0.3));
        z-index: 1;
    }

    .text-bg {
        background-color: rgba(50, 50, 50, 0.6);
        /* Ash tone */
        color: #fff;
        max-width: 800px;
        margin: 0 auto;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        padding: 0.6rem 0.9rem;
        border-radius: 50%;
        border: none;
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 1.25rem;
        cursor: pointer;
        z-index: 5;
        transition: background 0.3s;
    }

    .arrow-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .arrow-btn.start {
        left: 15px;
    }

    .arrow-btn.end {
        right: 15px;
    }

    .dot {
        width: 14px;
        height: 14px;
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .dot.active {
        background-color: white;
        width: 16px;
        height: 16px;
    }

    /* Doctor Slide */
    .doctor-slide {
        background: linear-gradient(135deg, #4b4f54, #2f3136);
        color: #fff;
        position: relative;
    }

    /* Doctor Image Base */
    .doctor-img {
        position: absolute;
        bottom: 0;
        max-height: 88%;
        object-fit: contain;
        filter: drop-shadow(0 20px 35px rgba(0, 0, 0, 0.55));
        transition: transform 0.6s ease;
    }

    .slide.active .doctor-img {
        transform: translateY(-6px);
    }

    /* Alignments */
    .doctor-img.right {
        right: 8%;
    }

    .doctor-img.left {
        left: 8%;
    }

    /* Typography polish */
    .doctor-slide h2 {
        letter-spacing: 0.3px;
    }

    .doctor-slide p {
        font-size: 1.05rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .doctor-img {
            position: static;
            max-height: 300px;
            margin: 1rem auto 0;
            display: block;
        }

        .doctor-slide {
            text-align: center;
            padding-top: 2rem;
        }
    }

    @media (max-width: 768px) {
        #slider {
            height: 50vh;
        }

        .display-5 {
            font-size: 1.5rem;
        }

        .lead {
            font-size: 1rem;
        }

        .text-bg {
            padding: 1rem;
            max-width: 90%;
        }
    }
</style>

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
