window.DailyReport = window.DailyReport || {};

window.DailyReport.initDateFilter = function () {
    const dayFilter = document.getElementById("day_filter");
    const customRange = document.getElementById("daily_custom_range");
    const fromDate = document.getElementById("daily_from_date");
    const toDate = document.getElementById("daily_to_date");

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

    if (!dayFilter || !customRange || !fromDate || !toDate) {
        return;
    }

    function toggleDailyDates() {
        if (dayFilter.value === "custom") {
            customRange.classList.remove("d-none");
        } else {
            customRange.classList.add("d-none");

            fromDate.value = "";
            toDate.value = "";
        }
    }

    dayFilter.addEventListener("change", function () {
        toggleDailyDates();

        const dayValue = dayFilter.value;
        const gender = genderSelect ? genderSelect.value : "";
        const recommend = recommendSelect ? recommendSelect.value : "";
        const emergency = emergencySelect ? emergencySelect.value : "";
        const treatment = treatmentSelect ? treatmentSelect.value : "";
        const investigated = investigationSelect
            ? investigationSelect.value
            : "";

        if (
            dayValue !== "" &&
            dayValue !== "custom" &&
            gender === "" &&
            recommend === "" &&
            emergency === "" &&
            treatment === "" &&
            investigated === ""
        ) {
            const modalElement = document.getElementById("filterWarningModal");

            if (modalElement) {
                new bootstrap.Modal(modalElement).show();
            }

            dayFilter.value = "";

            toggleDailyDates();
        }
    });

    toggleDailyDates();

    if (typeof window.DailyReport.updateSelectedArray === "function") {
        window.DailyReport.updateSelectedArray();
    }
};
