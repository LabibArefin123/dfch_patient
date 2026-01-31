    <section id="glance" class="bg-info text-white position-relative"
        style="background-color:#00a0d6; overflow:hidden;">
        <div class="container py-3 position-relative" style="z-index:1;">
            <div class="row g-0 align-items-start">
                <!-- Right: Text -->
                <div class="col-md-6 offset-md-6 d-flex flex-column justify-content-center ps-md-5">
                    <h5 class="text-uppercase mb-2" style="letter-spacing:1px;">At a Glance</h5>
                    <h2 class="fw-bold mb-3">Leading the Way in Colorectal Surgery</h2>

                    <ul class="list-unstyled glance-list mb-0">
                        <li>Founded by Prof. Dr. AKM Fazlul Haque</li>
                        <li>Pioneering Colorectal Surgery in South Asia</li>
                        <li>Over 30 Years of Excellence</li>
                        <li>World-Class Colorectal Care</li>
                        <li>Cutting-Edge Surgical Techniques</li>
                        <li>Global Expertise, Local Care</li>
                        <li>State-of-the-Art Facilities</li>
                        <li>24/7 Emergency and Personalized Care</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Left Image: Outside container -->
        <div class="glance-image position-absolute start-0 bottom-0" style="z-index:0; max-width:50%;">
            <img src="{{ asset('uploads/images/welcome_page/glance/glance.png') }}" alt="DFCH at a Glance"
                class="img-fluid" style="display:block; object-fit:contain; object-position:bottom; width:90%;">
        </div>

        <style>
            .glance-list li {
                margin-bottom: 10px;
                font-size: 16px;
                position: relative;
                padding-left: 25px;
            }

            .glance-list li::before {
                content: "\f0da";
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                position: absolute;
                left: 0;
                top: 0;
                color: #fff;
            }

            @media (max-width: 768px) {
                #glance .glance-image {
                    position: relative !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    margin-bottom: 15px;
                }

                #glance .row {
                    flex-direction: column-reverse;
                }

                .ps-md-5 {
                    padding-left: 0 !important;
                }
            }
        </style>
    </section>
