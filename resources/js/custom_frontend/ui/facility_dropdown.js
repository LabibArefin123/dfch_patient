document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.getElementById("facility_dropdown");

    if (!dropdown) return;

    const toggleLink = dropdown.querySelector(".dropdown-toggle");
    const menu = dropdown.querySelector(".dropdown-menu");

    if (!toggleLink || !menu) return;

    // Toggle dropdown
    toggleLink.addEventListener("click", function (e) {
        e.preventDefault();

        const isOpen = menu.classList.contains("show");

        document.querySelectorAll(".dropdown-menu.show").forEach((el) => {
            el.classList.remove("show");
        });

        menu.classList.toggle("show", !isOpen);
        toggleLink.setAttribute("aria-expanded", !isOpen);
    });

    // Close when clicking outside
    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target)) {
            menu.classList.remove("show");
            toggleLink.setAttribute("aria-expanded", "false");
        }
    });
});
