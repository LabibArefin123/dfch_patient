document.addEventListener("DOMContentLoaded", function () {
    const phoneLinks = document.querySelectorAll(".open-phone-modal");
    const phoneModalElement = document.getElementById("phoneModal");

    if (!phoneModalElement) return;

    const phoneModal = new bootstrap.Modal(phoneModalElement);

    // Open modal for all trigger links
    phoneLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            phoneModal.show();
        });
    });
});
