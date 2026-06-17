document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("navbarToggle");
    const sidebar = document.querySelector(".mobile-navbar");
    const overlay = document.querySelector(".mobile-navbar-overlay");
    const closeBtn = document.querySelector(".mobile-navbar-close");

    /* Open Sidebar */
    if (toggle) {
        toggle.addEventListener("click", function () {
            sidebar.classList.add("active");
            overlay.classList.add("active");
        });
    }

    /* Close Button */
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });
    }

    /* Click Overlay */
    if (overlay) {
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });
    }

    /* Mobile Dropdowns */
    const dropdowns = document.querySelectorAll(".mobile-dropdown-toggle");

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener("click", function () {
            const parent = this.closest(".mobile-dropdown");

            parent.classList.toggle("active");
        });
    });
});
