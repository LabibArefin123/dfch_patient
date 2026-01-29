<section class="py-5 bg-white" id="goals">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Left: Goals Content -->
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4 text-dark">
                    Our Goals
                </h2>

                <div class="goal-item d-flex mb-4">
                    <div class="goal-icon me-3">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Patient-Centered Care</h6>
                        <p class="mb-0 text-muted">
                            We deliver personalized, compassionate care tailored to the unique needs of every patient.
                        </p>
                    </div>
                </div>

                <div class="goal-item d-flex mb-4">
                    <div class="goal-icon me-3">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Innovative Treatments</h6>
                        <p class="mb-0 text-muted">
                            We stay at the forefront of medical advancement by refining and introducing modern surgical
                            techniques.
                        </p>
                    </div>
                </div>

                <div class="goal-item d-flex mb-4">
                    <div class="goal-icon me-3">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Education & Training</h6>
                        <p class="mb-0 text-muted">
                            We lead colorectal education through structured training programs for national and
                            international specialists.
                        </p>
                    </div>
                </div>

                <div class="goal-item d-flex">
                    <div class="goal-icon me-3">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Public Awareness</h6>
                        <p class="mb-0 text-muted">
                            We actively promote colorectal health awareness through impactful initiatives and community
                            programs.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Image Placeholder -->
            <div class="col-lg-6">
                <div class="about-image-placeholder">
                    <img src="{{ asset('uploads/images/welcome_page/goals/family.jpeg') }}"
                        alt="Dr. FazlulHaque Colorectal Hospital" class=""
                        style="max-height: 480px; object-fit: cover;">
                </div>
            </div>

        </div>
    </div>

    <!-- Page Styles -->
    <style>
        .goal-icon {
            width: 45px;
            height: 45px;
            background-color: #e8f6ff;
            color: #0dcaf0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .about-image-placeholder {
            width: 100%;
            height: 320px;
            border-radius: 12px;
            background-color: #f5f7fa;
            border: 2px dashed #cfd8dc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .about-image-placeholder {
                height: 260px;
            }
        }
    </style>
</section>
