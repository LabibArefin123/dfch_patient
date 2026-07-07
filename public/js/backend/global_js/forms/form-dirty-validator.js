document.addEventListener("DOMContentLoaded", function () {
    let isDirty = false;
    let lastBackHref = null;

    // Track changes on all inputs inside forms
    document.querySelectorAll("form").forEach((form) => {
        form.querySelectorAll("input, textarea, select").forEach((input) => {
            input.addEventListener("change", () => {
                isDirty = true;
            });
        });

        // Reset dirty flag on submit
        form.addEventListener("submit", () => {
            isDirty = false;
        });
    });

    // Handle all custom back buttons
    document.querySelectorAll(".back-btn").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            const href = btn.getAttribute("href");
            if (isDirty) {
                e.preventDefault();
                lastBackHref = href; // save the target URL
                $("#backConfirmModal").modal("show");
            } else {
                window.location.href = href;
            }
        });
    });

    // Leave page action from within the modal
    const leaveBtn = document.querySelector("#backConfirmModal .leave-page");
    if (leaveBtn) {
        leaveBtn.addEventListener("click", function () {
            if (lastBackHref) {
                isDirty = false;
                window.location.href = lastBackHref;
            }
        });
    }

    // Warn user if leaving by native browser navigation (refresh/back button)
    window.addEventListener("beforeunload", function (e) {
        if (isDirty) {
            e.preventDefault();
            e.returnValue = "";
        }
    });
});
