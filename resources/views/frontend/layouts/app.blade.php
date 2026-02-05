<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ config('app.name', 'Dr. Fazlul Haque Colorectal Hospital Limited (DFCH)') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/frontend/frontend.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS + dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration
            easing: 'ease-in-out', // Easing style
            once: true, // Only animate once
        });
    </script>
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to Top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script>
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    {{-- Start of image modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // create modal container
            const modal = document.createElement('div');
            modal.classList.add('image-modal');

            // create modal box inside modal
            modal.innerHTML = `
        <div class="modal-box">
            <span class="close-btn">&times;</span>
            <img src="" alt="Magnified Image">
        </div>
    `;
            document.body.appendChild(modal);

            const modalImg = modal.querySelector('img');
            const closeBtn = modal.querySelector('.close-btn');

            // open modal on click
            document.querySelectorAll('.magnify-img').forEach(img => {
                img.addEventListener('click', () => {
                    modal.style.display = 'flex';
                    modalImg.src = img.src;
                });
            });

            // close modal on close button click
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // close modal when clicking outside the modal-box
            modal.addEventListener('click', (e) => {
                if (!e.target.closest('.modal-box')) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
    {{-- end of image modal --}}

    {{-- start of land phone js  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneLink = document.querySelector('.phone-link');
            if (phoneLink) {
                // Get the number text
                let number = phoneLink.textContent.trim();

                // Remove any non-digit characters
                number = number.replace(/\D/g, '');

                // Add Bangladesh country code (assuming it's Dhaka landline, 02)
                // For mobile you could use 880 instead
                // Here 02 -> 8802
                if (number.length === 9 && number.startsWith('2')) { // Dhaka landline 9-digit
                    number = '880' + number;
                }

                // Set href for click-to-call
                phoneLink.href = 'tel:+' + number;

                // Optional: Add title
                phoneLink.title = 'Call this number';
            }
        });
    </script>
    {{-- end of land phone js  --}}

</body>

</html>
