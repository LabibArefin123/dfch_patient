<!-- Top Info Bar -->
<link rel="stylesheet" href="{{ asset('css/frontend/custom_topbar.css') }}">
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
             <a href="#" class="header-link open-phone-modal">
                <i class="fas fa-phone-alt"></i>
                01755697173
            </a>

            <span class="divider">|</span>

            <a href="#" class="header-link open-phone-modal">
                <i class="fas fa-phone-alt"></i>
                01755697176
            </a>
            <span>|</span>
            <a href="#" class="phone-link header-link">0241023155</a>

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
