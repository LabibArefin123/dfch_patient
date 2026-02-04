<!-- Top Info Bar -->
<div class="bg-info  py-2">
    <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">
        <style>
            .goog-te-banner-frame.skiptranslate,
            .goog-te-balloon-frame,
            #goog-gt-tt {
                display: none !important;
            }

            .goog-te-gadget {
                height: 0 !important;
                overflow: hidden;
            }
        </style>
        <!-- LEFT : Address + WhatsApp + Map -->
        <div class="d-flex align-items-center flex-wrap gap-2 text-white">
            <i class="fas fa-map-marker-alt"></i>
            <a href="#" class="header-link " id="openMapModal">
                86 (New), 726/A (Old), Satmasjid Road, Dhanmondi, Dhaka-1209
            </a>
            <span class="mx-2">|</span>
            <a href="https://wa.me/8801755697173" target="_blank" class="top-link">
                <i class="fab fa-whatsapp"></i> 01755697173
            </a>
            <span>-</span>
            <a href="https://wa.me/8801755697176" target="_blank" class="top-link">
                01755697176
            </a>
            <span>|</span>
            <a>
                0241023155
            </a>
        </div>
        <!-- Hidden Google Translate Widget -->
        <div id="google_translate_element" style="display:none;"></div>
        <!-- RIGHT : SOCIAL ICONS -->
        <div class="d-flex align-items-center gap-2">
            <a href="https://www.youtube.com/@ProfDrAKMFazlulHaque" target="_blank" class="social-icon">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="https://www.facebook.com/DrFazlulHaqueColorectalHospitalLtd/" class="social-icon" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <button id="langToggle"
                style="background:#ff6b6b; color:white; padding:6px 12px; border:none; border-radius:4px; cursor:pointer;">
                EN
            </button>
        </div>
    </div>

    <div id="mapModal" class="map-modal">
        <div class="map-modal-content">
            <span class="close-modal">&times;</span>
            <h4>Our Location</h4>

            <!-- Bigger Map -->
            <iframe src="https://www.google.com/maps?q=726/A+Satmasjid+Road,+Dhaka+1209,+Bangladesh&output=embed"
                width="100%" height="380" style="border:0; border-radius:8px;" allowfullscreen loading="lazy">
            </iframe>

            <!-- Map Action Buttons -->
            <div class="map-actions">
                <button class="map-btn google" onclick="openMap('google')">
                    🗺️ Google Maps
                </button>

                <button class="map-btn pathao" onclick="openMap('pathao')">
                    🚕 Pathao
                </button>

                <button class="map-btn uber" onclick="openMap('uber')">
                    🚖 Uber
                </button>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="{{ asset('css/frontend/custom_header.css') }}">
<!-- Main Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white"
    style="padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">

        <!-- Left: Logo -->
        <a href="{{ route('welcome') }}" class="navbar-brand d-flex align-items-center">

            @php
                $logoPath = null;

                if (!empty($orgPicture)) {
                    foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                        $path = public_path('uploads/images/backend/organization/' . $orgPicture . '.' . $ext);

                        if (file_exists($path)) {
                            $logoPath = asset('uploads/images/backend/organization/' . $orgPicture . '.' . $ext);
                            break;
                        }
                    }
                }
            @endphp

            @if ($logoPath)
                <img src="{{ $logoPath }}" alt="{{ $orgName }}" class="brand-image elevation-3"
                    style="width:350px; height:75px; object-fit: contain;">
            @else
                {{-- Fallback --}}
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Default Logo" class="brand-image elevation-3"
                    style="width:350px; height:75px; object-fit: contain;">
            @endif
        </a>


        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center Menu -->
        <div class="collapse navbar-collapse justify-content-center order-2" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('welcome') }}"
                        class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        Overview
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="#glance" class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        Overview
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="#about" class="nav-link custom-link">About</a>
                </li>

                <li class="nav-item">
                    <a href="#departments" class="nav-link custom-link">Departments</a>
                </li>

                <li class="nav-item">
                    <a href="#facilities" class="nav-link custom-link">Facilities</a>
                </li>

                <li class="nav-item">
                    <a href="#services" class="nav-link custom-link">Services</a>
                </li>

                <li class="nav-item">
                    <a href="#specialists" class="nav-link custom-link">Our Specialists</a>
                </li>

                <li class="nav-item">
                    <a href="#goals" class="nav-link custom-link">Our Goals</a>
                </li>
            </ul>
        </div>

        <!-- Right: Login Button -->
        <div class="order-3 ml-auto d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn login-btn" style="margin-right: 10px;">Login</a>
        </div>

    </div>
</nav>

<!----start of map js--->
<script>
    const address = "726/A Satmasjid Road, Dhaka 1209, Bangladesh";

    document.addEventListener("DOMContentLoaded", function() {
        const openBtn = document.getElementById("openMapModal");
        const modal = document.getElementById("mapModal");
        const closeBtn = document.querySelector(".close-modal");

        if (openBtn && modal) {
            openBtn.addEventListener("click", function(e) {
                e.preventDefault();
                modal.style.display = "flex";
            });
        }

        if (closeBtn && modal) {
            closeBtn.addEventListener("click", function() {
                modal.style.display = "none";
            });
        }

        if (modal) {
            modal.addEventListener("click", function(e) {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
        }
    });

    // ✅ MUST be global for onclick buttons
    function openMap(app) {
        const encoded = encodeURIComponent(address);

        const links = {
            google: `https://www.google.com/maps/search/?api=1&query=${encoded}`,
            pathao: `pathao://maps?destination=${encoded}`,
            uber: `uber://?action=setPickup&dropoff[formatted_address]=${encoded}`
        };

        const fallbackUrl = links.google;
        const targetUrl = links[app] || fallbackUrl;

        let fallbackTriggered = false;

        const fallbackTimer = setTimeout(() => {
            fallbackTriggered = true;
            window.open(fallbackUrl, "_blank");
        }, 800);

        window.location.href = targetUrl;

        window.addEventListener(
            "blur",
            () => {
                if (!fallbackTriggered) {
                    clearTimeout(fallbackTimer);
                }
            }, {
                once: true
            }
        );
    }
</script>
<!------end of map js--->

<!------start of welcome link js--->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeUrl = "{{ route('welcome') }}";

        document.querySelectorAll('a.nav-link[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');

                // If NOT on welcome page
                if (window.location.pathname !== new URL(welcomeUrl).pathname) {
                    e.preventDefault();
                    window.location.href = welcomeUrl + targetId;
                }
            });
        });
    });
</script>
<!------end of welcome link js--->

<!------start of translate english/bangla link js--->
<!-- Google Translate Init -->
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,bn',
            autoDisplay: false
        }, 'google_translate_element');
    }

    function setGoogleLanguage(lang) {
        const interval = setInterval(() => {
            const select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event('change'));
                clearInterval(interval);
            }
        }, 200);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById("langToggle");

        // Restore saved language
        const savedLang = localStorage.getItem("site_lang") || "en";
        btn.innerText = savedLang.toUpperCase();
        if (savedLang === "bn") setGoogleLanguage("bn");

        btn.addEventListener("click", function() {
            const currentLang = btn.innerText.toLowerCase();
            const newLang = currentLang === "en" ? "bn" : "en";

            setGoogleLanguage(newLang);
            btn.innerText = newLang.toUpperCase();
            localStorage.setItem("site_lang", newLang);
        });
    });
</script>

<!-- Google Translate Library -->
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!------start of translate english/bangla link js--->
