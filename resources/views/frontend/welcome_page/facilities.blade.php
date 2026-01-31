<section id="facilities" class="py-5 bg-white">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Facilities</h2>
            <p class="text-muted mt-2 mx-auto" style="max-width: 720px;">
                At Dr. Fazlul Haque Colorectal Hospital (DFCH), our facilities are thoughtfully designed
                to ensure patient safety, comfort, and the highest standard of medical care.
            </p>
        </div>

        <!-- Tabs -->
        <div class="d-flex justify-content-center gap-3 mb-5 flex-wrap facility-tabs">
            <button class="facility-tab active" data-target="icu">
                <i class="fas fa-heartbeat"></i>
                <span>ICU</span>
            </button>

            <button class="facility-tab" data-target="lab">
                <i class="fas fa-vials"></i>
                <span>Laboratory</span>
            </button>

            <button class="facility-tab" data-target="ot">
                <i class="fas fa-procedures"></i>
                <span>Operation Theater</span>
            </button>

            <button class="facility-tab" data-target="xray">
                <i class="fas fa-x-ray"></i>
                <span>X-Ray Diagnostics</span>
            </button>
        </div>

        <!-- ICU -->
        <div class="facility-content active" id="icu">
            <div class="row align-items-center g-5">
                <div class="col-md-5">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/icu.jpeg') }}" alt="ICU Facility at DFCH"
                        class="img-fluid rounded shadow-sm facility-image">
                </div>
                <div class="col-md-7">
                    <h4 class="fw-bold">Intensive Care Unit (ICU)</h4>
                    <p>
                        Our Intensive Care Unit is a fully equipped, seven-bed facility dedicated to
                        providing continuous monitoring and life-saving support for critically ill patients.
                    </p>
                    <ul class="facility-list">
                        <li><strong>Critical Care Equipment:</strong> Ventilators, cardiac monitors, infusion pumps,
                            centralized medical gas systems, and controlled air conditioning.</li>
                        <li><strong>High Standards of Care:</strong> Regular equipment upgrades, monthly clinical
                            reviews, and multidisciplinary medical discussions.</li>
                        <li><strong>Specialist Team:</strong> Experienced ICU doctors and trained nurses delivering
                            round-the-clock expert care.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Laboratory -->
        <div class="facility-content" id="lab">
            <div class="row align-items-center g-5">
                <div class="col-md-5">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/laboratory.jpeg') }}"
                        alt="Laboratory Services at DFCH" class="img-fluid rounded shadow-sm facility-image">
                </div>
                <div class="col-md-7">
                    <h4 class="fw-bold">Laboratory Services</h4>
                    <p>
                        Our in-house laboratory provides accurate, timely, and reliable diagnostic
                        services to support effective medical decision-making.
                    </p>
                    <ul class="facility-list">
                        <li><strong>Comprehensive Testing:</strong> Hematology, biochemistry, immunology,
                            serology, and clinical pathology.</li>
                        <li><strong>Advanced Equipment:</strong> Automated analyzers, blood gas machines,
                            biosafety cabinets, and tissue processors.</li>
                        <li><strong>Quality Assurance:</strong> Strict quality control protocols to ensure
                            precision and consistency in every report.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Operation Theater -->
        <div class="facility-content" id="ot">
            <div class="row align-items-center g-5">
                <div class="col-md-5">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/ot.jpeg') }}"
                        alt="Operation Theater at DFCH" class="img-fluid rounded shadow-sm facility-image">
                </div>
                <div class="col-md-7">
                    <h4 class="fw-bold">Operation Theater (OT)</h4>
                    <p>
                        DFCH features four modern operation theaters built to support advanced
                        colorectal and general surgical procedures in a sterile, controlled environment.
                    </p>
                    <ul class="facility-list">
                        <li><strong>Advanced Lighting:</strong> Double-dome LED multicolor lights for
                            clear and focused surgical visibility.</li>
                        <li><strong>Air & Ventilation:</strong> HVAC-controlled temperature and humidity,
                            along with touchless hermetic doors.</li>
                        <li><strong>Specialized Surgical Systems:</strong> Laparoscopic, colonoscopy,
                            and other state-of-the-art equipment.</li>
                        <li><strong>Automatic Scrub Area:</strong> Dedicated preparation zones for surgeons
                            and medical staff.</li>
                        <li><strong>Reliable Power Backup:</strong> Central UPS, 670KVA generator,
                            and a dedicated OT power supply.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- X-Ray -->
        <div class="facility-content" id="xray">
            <div class="row align-items-center g-5">
                <div class="col-md-5">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/xray.jpeg') }}"
                        alt="Radiology and Imaging at DFCH" class="img-fluid rounded shadow-sm facility-image">
                </div>
                <div class="col-md-7">
                    <h4 class="fw-bold">Radiology & Imaging</h4>
                    <p>
                        Our Radiology and Imaging department offers advanced diagnostic services
                        using modern imaging technology for accurate and timely results.
                    </p>
                    <ul class="facility-list">
                        <li><strong>State-of-the-Art Technology:</strong> 1000mA digital X-ray with fluoroscopy,
                            2D & 3D/4D ultrasonography, and portable X-ray facilities.</li>
                        <li><strong>Expert Professionals:</strong> Qualified radiologists and technologists
                            ensuring precise imaging and reporting.</li>
                        <li><strong>Advanced Diagnostics:</strong> Modern digital imaging systems supporting
                            comprehensive patient evaluation.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom_facilities.css') }}">

    <!-- Script -->
    <script>
        document.querySelectorAll('.facility-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.facility-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.facility-content').forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tab.dataset.target).classList.add('active');
            });
        });
    </script>
</section>
