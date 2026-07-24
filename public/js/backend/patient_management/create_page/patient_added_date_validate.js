/**
 * --------------------------------------------------------------------------
 * Patient Registration Date Validation
 * --------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    initializePatientDateValidation();
});

let futureTestingApproved = false;
let lastValidDate = "";

function initializePatientDateValidation() {
    const input = document.getElementById("date_of_patient_added");

    if (!input) return;

    lastValidDate = input.value;

    input.addEventListener("change", function () {
        validatePatientDate(this);
    });

    const allowBtn = document.getElementById("allowFutureDate");
    const cancelBtn = document.getElementById("cancelFutureDate");

    if (allowBtn) {
        allowBtn.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            futureTestingApproved = true;

            closeFutureDateModal();

            updatePatientAddedDateInfo(input.value);
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            futureTestingApproved = false;

            closeFutureDateModal();

            updatePatientAddedDateInfo(input.value);
        });
    }
}

/**
 * --------------------------------------------------------------------------
 * Validate Date
 * --------------------------------------------------------------------------
 */
function validatePatientDate(input) {
    if (!input.value) {
        futureTesting = false;
        return;
    }

    const selected = new Date(input.value + "T00:00:00");

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selected.getTime() > today.getTime()) {
        futureTestingApproved = false;

        openFutureDateModal();
    } else {
        futureTestingApproved = false;

        lastValidDate = input.value;

        updatePatientAddedDateInfo(input.value);
    }
}

/**
 * --------------------------------------------------------------------------
 * Open Modal (Bootstrap 4 & 5)
 * --------------------------------------------------------------------------
 */
function openFutureDateModal() {
    const modal = document.getElementById("futureDateModal");

    if (!modal) {
        console.error("futureDateModal not found.");
        return;
    }

    // Bootstrap 5
    if (typeof bootstrap !== "undefined") {
        const instance = bootstrap.Modal.getOrCreateInstance(modal, {
            backdrop: "static",
            keyboard: false,
        });

        instance.show();
        return;
    }

    // Bootstrap 4
    if (typeof $ !== "undefined" && $.fn.modal) {
        $("#futureDateModal").modal({
            backdrop: "static",
            keyboard: false,
        });

        $("#futureDateModal").modal("show");
    }
}

/**
 * --------------------------------------------------------------------------
 * Close Modal
 * --------------------------------------------------------------------------
 */
function closeFutureDateModal() {
    const modal = document.getElementById("futureDateModal");

    if (!modal) return;

    // Bootstrap 5
    if (typeof bootstrap !== "undefined") {
        bootstrap.Modal.getOrCreateInstance(modal).hide();
        return;
    }

    // Bootstrap 4
    if (typeof $ !== "undefined" && $.fn.modal) {
        $("#futureDateModal").modal("hide");
    }
}
