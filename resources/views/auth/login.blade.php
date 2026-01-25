@extends('frontend.layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-glass" id="sliderContainer">

            {{-- LEFT : ABOUT --}}
            <div class="about-slider">
                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                {{-- SHORT ABOUT --}}
                <div class="about-content short" id="aboutShort">
                    <h4 class="fw-bold mb-3">About DFCH</h4>
                    <p>
                        <strong>Dr. Fazlul Haque Colorectal Hospital Limited (DFCH)</strong> is a
                        specialized center of excellence in colorectal surgery, established on
                        <strong>23rd June 2024</strong>, committed to advanced and compassionate care.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        More Information
                    </button>
                </div>

                {{-- FULL ABOUT --}}
                <div class="about-content full" id="aboutFull">
                    <h4 class="fw-bold mb-3">A Legacy of Dedication & Innovation</h4>

                    <p>
                        Dr. Fazlul Haque Colorectal Hospital Limited stands as a beacon of excellence
                        in colorectal surgery. Established on 23rd June 2024, the hospital is dedicated
                        to providing unparalleled care through innovation and medical expertise.
                    </p>

                    <h5 class="mt-3">Our Mission</h5>
                    <p>
                        To provide world-class colorectal care through innovative surgical practices,
                        personalized treatment plans, and an unwavering commitment to patient well-being.
                    </p>

                    <h5 class="mt-3">Our Vision</h5>
                    <p>
                        To become a global leader in colorectal surgery by pioneering advancements,
                        fostering continuous learning, and improving quality of life.
                    </p>

                    <h5 class="mt-3">Our Goals</h5>
                    <ul class="ps-3">
                        <li>Patient-centered personalized care</li>
                        <li>Innovative and advanced surgical treatments</li>
                        <li>Education & training for specialists</li>
                        <li>Public awareness of colorectal health</li>
                    </ul>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(false)">
                        Show Less
                    </button>
                </div>
            </div>


            {{-- RIGHT : LOGIN --}}
            <div class="login-panel">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-success">Secure Login</h4>
                    <p class="text-muted">Hospital Management System</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email or Username</label>
                        <input type="text" name="login" class="form-control form-control-lg"
                            placeholder="Enter email or username">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg"
                            placeholder="Enter password">
                    </div>

                    <button class="btn btn-success w-100 py-2 rounded-pill mt-3">
                        Login
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" id="forgotPasswordLink" class="text-decoration-none">
                            Forgot Password?
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- STYLES --}}
    <style>
        body {
            background: url('{{ asset('uploads/images/login_page/wallpaper.jpg') }}') center/cover no-repeat;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-glass {
            width: 95%;
            max-width: 1200px;
            height: 600px;
            display: flex;
            border-radius: 25px;
            overflow: hidden;
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, .15);
            box-shadow: 0 25px 60px rgba(0, 0, 0, .35);
            transition: transform .8s ease;
        }

        /* DEFAULT → LOGIN ON RIGHT */
        .login-glass.login-active {
            transform: translateX(0);
        }

        /* SLIDE TO ABOUT */
        .login-glass.about-active {
            transform: translateX(-45%);
        }

        .hospital-logo {
            width: 520px;
            /* increased width only */
            height: 150px;
            /* height unchanged */
            object-fit: contain;
            margin-bottom: 25px;
        }

        .about-slider {
            width: 55%;
            padding: 45px;
            background: linear-gradient(135deg, #0f5132, #198754);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .about-content {
            transition: all .5s ease;
        }

        .about-content.full {
            display: none;
            max-height: 320px;
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Scrollbar (clean & subtle) */
        .about-content.full::-webkit-scrollbar {
            width: 5px;
        }

        .about-content.full::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .4);
            border-radius: 10px;
        }

        .login-panel {
            width: 45%;
            padding: 55px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Responsive */
        @media(max-width:992px) {
            .login-glass {
                flex-direction: column;
                height: auto;
                transform: none !important;
            }

            .about-slider,
            .login-panel {
                width: 100%;
            }
        }
    </style>

    {{-- SLIDER JS --}}
    <script>
        function toggleAbout(showFull) {
            const shortAbout = document.getElementById('aboutShort');
            const fullAbout = document.getElementById('aboutFull');

            if (showFull) {
                shortAbout.style.display = 'none';
                fullAbout.style.display = 'block';
            } else {
                fullAbout.style.display = 'none';
                shortAbout.style.display = 'block';
            }
        }
    </script>
@endsection
