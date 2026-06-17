function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {
            pageLanguage: "en",
            includedLanguages: "en,bn",
            autoDisplay: false,
        },
        "google_translate_element",
    );
}

function setGoogleLanguage(lang) {
    const interval = setInterval(() => {
        const select = document.querySelector(".goog-te-combo");
        if (select) {
            select.value = lang;
            select.dispatchEvent(new Event("change"));
            clearInterval(interval);
        }
    }, 200);
}

document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("langToggle");

    // Restore saved language
    const savedLang = localStorage.getItem("site_lang") || "en";
    btn.innerText = savedLang.toUpperCase();
    if (savedLang === "bn") setGoogleLanguage("bn");

    btn.addEventListener("click", function () {
        const currentLang = btn.innerText.toLowerCase();
        const newLang = currentLang === "en" ? "bn" : "en";

        setGoogleLanguage(newLang);
        btn.innerText = newLang.toUpperCase();
        localStorage.setItem("site_lang", newLang);
    });
});
