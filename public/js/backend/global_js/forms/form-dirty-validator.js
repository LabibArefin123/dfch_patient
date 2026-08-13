document.addEventListener("DOMContentLoaded", function () {
    let isDirty = false;
    let lastBackHref = null;
    let leavingPage = false;

    /*
    |--------------------------------------------------------------------------
    | Track Form Changes
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll("form").forEach((form) => {
        form.querySelectorAll("input, textarea, select").forEach((input) => {
            input.addEventListener("input", function () {
                isDirty = true;
            });

            input.addEventListener("change", function () {
                isDirty = true;
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Successful Form Submit
        |--------------------------------------------------------------------------
        */

        form.addEventListener("submit", function () {
            isDirty = false;
            leavingPage = true;
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Back Buttons ONLY
    |--------------------------------------------------------------------------
    |
    | The confirmation modal is intentionally attached only to .back-btn.
    |
    */

    document.querySelectorAll(".back-btn").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            const href = btn.getAttribute("href");

            if (!href) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | No unsaved changes
            |--------------------------------------------------------------------------
            */

            if (!isDirty) {
                e.preventDefault();

                leavingPage = true;

                window.location.href = href;

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Unsaved changes
            |--------------------------------------------------------------------------
            */

            e.preventDefault();

            lastBackHref = href;

            $("#backConfirmModal").modal("show");
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Leave Page
    |--------------------------------------------------------------------------
    */

    const leaveBtn = document.querySelector("#backConfirmModal .leave-page");

    if (leaveBtn) {
        leaveBtn.addEventListener("click", function () {
            if (!lastBackHref || leavingPage) {
                return;
            }

            leavingPage = true;

            /*
                |--------------------------------------------------------------------------
                | Disable button to prevent double-click
                |--------------------------------------------------------------------------
                */

            leaveBtn.disabled = true;

            /*
                |--------------------------------------------------------------------------
                | Save latest data before leaving
                |--------------------------------------------------------------------------
                */

            if (
                window.PatientTemporarySave &&
                typeof window.PatientTemporarySave.save === "function"
            ) {
                window.PatientTemporarySave.save({
                    complete: function () {
                        isDirty = false;

                        window.location.href = lastBackHref;
                    },
                });

                return;
            }

            /*
                |--------------------------------------------------------------------------
                | No temporary-save module
                |--------------------------------------------------------------------------
                */

            isDirty = false;

            window.location.href = lastBackHref;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Modal
    |--------------------------------------------------------------------------
    */

    const cancelButtons = document.querySelectorAll(
        "#backConfirmModal .cancel-page",
    );

    cancelButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            lastBackHref = null;
        });
    });
});
