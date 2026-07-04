window.DailyReport = window.DailyReport || {};

window.DailyReport.initDateFilter = function () {
    const dayFilter = document.getElementById("day_filter");
    const customRange = document.getElementById("daily_custom_range");
    const fromDate = document.getElementById("daily_from_date");
    const toDate = document.getElementById("daily_to_date");

    if (!dayFilter || !customRange || !fromDate || !toDate) return;

    function toggleDailyDates() {
        if (dayFilter.value === "custom") {
            customRange.classList.remove("d-none");
        } else {
            customRange.classList.add("d-none");
            fromDate.value = "";
            toDate.value = "";
        }
    }

    dayFilter.addEventListener("change", toggleDailyDates);
    toggleDailyDates();
};
