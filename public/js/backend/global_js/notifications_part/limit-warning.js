document.addEventListener("DOMContentLoaded", function () {
    const config = window.Laravel || {};
    const totalRecords = config.totalRecords ?? 0;
    const limit = 500;

    if (totalRecords >= limit) {
        const modalEl = document.getElementById("limitWarningModal");
        if (modalEl) {
            setTimeout(() => {
                // Safely instantiate and show bootstrap modal
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }, 600); // small delay for smooth UX transition
        }
    }
});
