document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("slider");

    // ✅ Stop if slider does not exist (other pages)
    if (!slider) return;

    let currentIndex = 0;
    const slides = slider.querySelectorAll(".slide");
    const dots = slider.querySelectorAll(".dot");
    const link = document.getElementById("doctorLink");

    // ✅ Stop if no slides
    if (slides.length === 0) return;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
        });

        if (link) {
            const route = slides[index].dataset.route;

            if (route) {
                link.href = route;
                link.style.pointerEvents = "auto";
            } else {
                link.href = "javascript:void(0)";
                link.style.pointerEvents = "none";
            }
        }

        currentIndex = index;
    }

    function nextSlide() {
        showSlide((currentIndex + 1) % slides.length);
    }

    function prevSlide() {
        showSlide((currentIndex - 1 + slides.length) % slides.length);
    }

    window.goToSlide = function (index) {
        showSlide(index);
    };

    setInterval(nextSlide, 15000);
    showSlide(0);
});
