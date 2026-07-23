document.addEventListener("DOMContentLoaded", function () {
    const weekFilter = document.getElementById("week_filter");
    const customDateRange = document.getElementById("custom_date_range");
    const fromDate = document.getElementById("from_date");
    const toDate = document.getElementById("to_date");
    const genderSelect = document.querySelector('select[name="gender"]');
    const recommendSelect = document.querySelector(
        'select[name="is_recommend"]',
    );
    const emergencySelect = document.querySelector(
        'select[name="is_emergency"]',
    );
    const treatmentSelect = document.querySelector(
        'select[name="is_treatment"]',
    );
    const investigationSelect = document.querySelector(
        'select[name="is_investigated"]',
    );

    function toggleDateFields() {
        if (!weekFilter) return;

        if (weekFilter.value === "custom") {
            customDateRange.classList.remove("d-none");
        } else {
            customDateRange.classList.add("d-none");

            if (fromDate) fromDate.value = "";
            if (toDate) toDate.value = "";
        }
    }

    if (weekFilter) {
        weekFilter.addEventListener("change", function () {
            toggleDateFields();

            const weekValue = weekFilter.value;
            const gender = genderSelect ? genderSelect.value : "";
            const recommend = recommendSelect ? recommendSelect.value : "";
            const emergency = emergencySelect ? emergencySelect.value : "";
            const treatment = treatmentSelect ? treatmentSelect.value : "";
            const investigated = investigationSelect
                ? investigationSelect.value
                : "";

            if (
                weekValue !== "" &&
                weekValue !== "custom" &&
                gender === "" &&
                recommend === "" &&
                emergency === "" &&
                treatment === "" &&
                investigated === ""
            ) {
                const modalElement =
                    document.getElementById("filterWarningModal");

                if (modalElement) {
                    new bootstrap.Modal(modalElement).show();
                }

                weekFilter.value = "";
            }
        });
    }

    toggleDateFields();

    if (typeof updateSelectedArray === "function") {
        updateSelectedArray();
    }
});
