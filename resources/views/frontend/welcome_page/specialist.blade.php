<section id="specialists" class="py-5 bg-white">
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
                            'route' => null,
                        ],
                        [
                            'image' => 'image_3.jpg',
                            'name' => 'Dr. Fatema Sharmin (Anny)',
                            'degree' => 'MBBS, DA, FCPS (Final)',
                            'details' => 'Consultant (Anesthesiology), DFCH<br>
                                 Junior Consultant, Bangladesh Medical College Hospital',
                            'route' => null,
                        ],
                        [
                            'image' => 'image_4.jpg',
                            'name' => 'Dr. Sakib Sarwat Haque',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                            'route' => null,
                        ],
                        [
                            'image' => 'image_5.jpg',
                            'name' => 'Dr. Asma Husain Noora',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                            'route' => null,
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
                <div id="spec-info">
                    <h3 class="fw-bold" id="docName">{{ $doctors[0]['name'] }}</h3>
                    <p class="text-danger fw-semibold" id="docDegree">{{ $doctors[0]['degree'] }}</p>
                    <p class="lh-lg" id="docDetails">{!! $doctors[0]['details'] !!}</p>
                </div>
            </div>

        </div>
    </div>
</section>

<link rel="stylesheet" href="{{ asset('css/frontend/custom_specialist.css') }}">
<script>
    let currentDoctor = 0;
    let autoSlide;
    const slideInterval = 15000;
    const doctors = @json($doctors);

    const previewImg = document.getElementById('previewImg');
    const doctorLink = document.getElementById('doctorLink');
    const docName = document.getElementById('docName');
    const docDegree = document.getElementById('docDegree');
    const docDetails = document.getElementById('docDetails');
    const stripItems = document.querySelectorAll('.strip-item');

    function startAutoSlide() {
        clearInterval(autoSlide);
        autoSlide = setInterval(nextDoctor, slideInterval);
    }

    function updateDoctor(index, resetTimer = true) {
        const doctor = doctors[index];

        stripItems.forEach((el, i) => {
            el.classList.toggle('active', i === index);
        });

        previewImg.src = "{{ asset('uploads/images/welcome_page/doctors/') }}/" + doctor.image;
        docName.innerText = doctor.name;
        docDegree.innerText = doctor.degree;
        docDetails.innerHTML = doctor.details;

        // Enable link ONLY if route exists
        if (doctor.route) {
            doctorLink.href = doctor.route;
            doctorLink.style.pointerEvents = 'auto';
        } else {
            doctorLink.href = 'javascript:void(0)';
            doctorLink.style.pointerEvents = 'none';
        }

        currentDoctor = index;
        if (resetTimer) startAutoSlide();
    }

    function nextDoctor() {
        updateDoctor((currentDoctor + 1) % doctors.length, false);
    }

    // Hover preview
    stripItems.forEach(item => {
        const index = item.dataset.index;

        item.addEventListener('mouseenter', () => {
            previewImg.src =
                "{{ asset('uploads/images/welcome_page/doctors/') }}/" + doctors[index].image;
        });

        item.addEventListener('click', e => {
            e.preventDefault();
            updateDoctor(index);
        });
    });

    // Init
    updateDoctor(0);
    startAutoSlide();
</script>
