document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".footer-action").forEach(function (el) {
        el.addEventListener("click", function () {
            const action = this.dataset.action;
            let modalId = null;

            if (action === "location") modalId = "locationModalFooter";
            if (action === "phone") modalId = "phoneModalFooter";
            if (action === "email") modalId = "emailModalFooter";

            if (modalId) {
                const modalElement = document.getElementById(modalId);
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    });
});
