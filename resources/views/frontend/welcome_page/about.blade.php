<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/about_section/about_base.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/about_section/about_content.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/about_section/about_image.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/about_section/about_links.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/about_section/about_responsive.css') }}">
<section class="about-section">

    <div class="text-center mb-5">

        <span class="about-badge">
            About Us
        </span>

        <h2 class="about-main-title">
            About {{ $orgName }}
        </h2>

        <p class="about-tagline">
            The First Specialized Colorectal Hospital in Bangladesh & The Subcontinent
        </p>

    </div>

    <div class="row align-items-center gy-5">

        <!-- Image -->
        <div class="col-lg-5">

            <div class="about-image-wrapper">

                <img src="{{ asset('uploads/images/welcome_page/about/building.jpg') }}" alt="{{ $orgName }}"
                    class="about-image">

            </div>

        </div>

        <!-- Content -->
        <div class="col-lg-7">

            <div class="about-card">

                <h3 class="about-title">
                    A Legacy of Excellence, Compassion & Innovation
                </h3>

                <p class="about-text">
                    <strong>
                        <a href="https://fazlulhaquehospital.com/" target="_blank" class="header-link text-white">
                            {{ $orgName }} (DFCH)
                        </a>
                    </strong>
                    is a premier center dedicated exclusively to colorectal healthcare.
                    Established on <strong>23 June 2024</strong>, the hospital was founded with a vision
                    to provide specialized, patient-centered and world-class treatment through advanced
                    medical expertise and compassionate care.
                </p>

                <p class="about-text">
                    DFCH delivers comprehensive colorectal services ranging from preventive screening
                    and diagnosis to advanced surgical procedures, rehabilitation and long-term patient
                    support. Every service is designed around patient comfort, dignity, safety and
                    successful recovery.
                </p>

                <div class="row g-3 mt-3">

                    <div class="col-md-6">
                        <div class="info-box-card">
                            <h5>Our Mission</h5>
                            <p>
                                Deliver world-class colorectal healthcare through innovation,
                                advanced treatment and compassionate patient care.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box-card">
                            <h5>Our Vision</h5>
                            <p>
                                Become a globally recognized leader through research,
                                innovation and clinical excellence.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
