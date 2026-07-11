document.addEventListener("DOMContentLoaded", function () {
    const locationLink = document.getElementById("openMapModal");

    if (locationLink) {
        locationLink.addEventListener("click", function (e) {
            e.preventDefault();

            const modalElement = document.getElementById("locationModal");

            const modal = new bootstrap.Modal(modalElement);

            modal.show();
        });
    }
});
