document.addEventListener("DOMContentLoaded", function () {
    const progressBar = document.getElementById("scrollProgress");

    window.addEventListener("scroll", () => {
        const scrollTop = window.scrollY; // Current scroll position
        const docHeight =
            document.documentElement.scrollHeight - window.innerHeight; // Total scrollable height
        const scrollPercent = (scrollTop / docHeight) * 100; // Percentage scrolled

        progressBar.style.width = scrollPercent + "%";
    });
});
