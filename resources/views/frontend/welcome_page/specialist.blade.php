<section id="specialists" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Medical Specialists</h2>
            <p class="text-muted fs-5">
                Experienced hands, compassionate care, and excellence in colorectal health.
            </p>
        </div>

        <div class="row align-items-center">
            <!-- LEFT : PARALLELOGRAM CARD SLIDER -->
            <div class="col-lg-5 position-relative specialist-left">

                <!-- Arrow Left -->
                <button class="spec-arrow left" onclick="prevDoctor()">‹</button>
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
                        ],
                        [
                            'image' => 'image_2.jpg',
                            'name' => 'Dr. Asif Almas Haque',
                            'degree' => 'MBBS, FCPS, FRCS, FACS, FASCRS',
                            'details' => 'Consultant, Colorectal, Laparoscopic & Laser Surgeon<br>
                Member, American Society of Colon & Rectal Surgeons',
                        ],
                        [
                            'image' => 'image_3.jpg',
                            'name' => 'Dr. Fatema Sharmin (Anny)',
                            'degree' => 'MBBS, DA, FCPS (Final)',
                            'details' => 'Consultant (Anesthesiology), DFCH<br>
                Junior Consultant, Bangladesh Medical College Hospital',
                        ],
                        [
                            'image' => 'image_4.jpg',
                            'name' => 'Dr. Sakib Sarwat Haque',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                        ],
                        [
                            'image' => 'image_5.jpg',
                            'name' => 'Dr. Asma Husain Noora',
                            'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                            'details' => 'Consultant Surgeon, DFCH',
                        ],
                    ];
                @endphp

                <div class="spec-image-slider">
                    @foreach ($doctors as $i => $doc)
                        <a href="#" class="spec-image-card {{ $i == 0 ? 'active' : '' }}"
                            onclick="updateDoctor({{ $i }}); return false;">

                            <div class="image-wrap">
                                <img src="{{ asset('uploads/images/welcome_page/doctors/' . $doc['image']) }}"
                                    alt="{{ $doc['name'] }}">

                                <div class="image-hover">
                                    <span>View Information</span>
                                </div>
                            </div>

                            <div class="image-footer"></div>
                        </a>
                    @endforeach
                </div>

                <!-- Arrow Right -->
                <button class="spec-arrow right" onclick="nextDoctor()">›</button>
            </div>


            <!-- RIGHT : DOCTOR INFO -->
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

<link rel="stylesheet" href="{{ asset('css/custom_specialist.css') }}">

<script>
    let currentDoctor = 0;
    const doctors = @json($doctors);

    function updateDoctor(index) {
        document.querySelectorAll('.spec-image-card').forEach((el, i) => {
            el.classList.toggle('active', i === index);
        });

        document.getElementById('docName').innerText = doctors[index].name;
        document.getElementById('docDegree').innerText = doctors[index].degree;
        document.getElementById('docDetails').innerHTML = doctors[index].details;

        // MOVE SLIDER
        document.querySelector('.spec-image-slider').style.transform =
            `translateX(-${index * 242}px)`;

        currentDoctor = index;
    }

    function nextDoctor() {
        updateDoctor((currentDoctor + 1) % doctors.length);
    }

    function prevDoctor() {
        updateDoctor((currentDoctor - 1 + doctors.length) % doctors.length);
    }

    document.querySelectorAll('.spec-card').forEach((card, index) => {
        card.addEventListener('click', () => updateDoctor(index));
    });
</script>
