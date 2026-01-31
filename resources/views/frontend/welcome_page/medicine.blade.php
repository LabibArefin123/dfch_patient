<section id="modern-medicine" class="text-white position-relative"
    style="background: linear-gradient(135deg, #008db8, #00a0d6); overflow:hidden;">

    <div class="container py-5">
        <div class="row align-items-center">

            <!-- Left: Text Content -->
            <div class="col-md-7">
                <h6 class="text-uppercase mb-2" style="letter-spacing:1px;">
                    Modern Medicine
                </h6>

                <h2 class="fw-bold mb-4">
                    Better Technology. Better Care.
                </h2>

                <p class="mb-3 fs-5">
                    We combine modern medical technology with decades of clinical experience
                    to provide safer, faster, and more comfortable treatment for our patients.
                </p>

                <p class="mb-4">
                    Many conditions can now be treated without major surgery. Our focus is on
                    minimizing pain, reducing recovery time, and helping you return to your
                    normal life as quickly as possible.
                </p>

                <ul class="list-unstyled modern-list">
                    <li>Advanced non-surgical treatment options</li>
                    <li>Proven techniques with high success rates</li>
                    <li>Less pain, shorter recovery time</li>
                    <li>Patient-focused and personalized care</li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Right Image (Outside Container, Bottom Aligned) -->
    <div class="modern-image">
        <img src="{{ asset('uploads/images/welcome_page/medicine/dr_fazlul_haque.png') }}" alt="Modern Medicine">
    </div>

    <style>
        .modern-list li {
            margin-bottom: 12px;
            padding-left: 28px;
            position: relative;
            font-size: 16px;
        }

        .modern-list li::before {
            content: "\f058";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 2px;
            color: #ffffff;
        }

        /* Image positioning */
        .modern-image {
            position: absolute;
            right: 0;
            bottom: 0;
            height: 100%;
            display: flex;
            align-items: flex-end;
            pointer-events: none;
        }

        .modern-image img {
            max-height: 520px;
            width: auto;
            object-fit: contain;
        }

        /* Responsive: move image below content */
        @media (max-width: 768px) {
            .modern-image {
                position: static;
                display: block;
                text-align: center;
                padding-bottom: 30px;
            }

            .modern-image img {
                max-height: 380px;
            }
        }
    </style>

</section>
 