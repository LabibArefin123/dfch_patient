const reportPdfRoute = reportConfig.pdfRoute;
const reportExcelRoute = reportConfig.excelRoute;

document.addEventListener("DOMContentLoaded", function () {
    const year = document.querySelector('select[name="year"]');
    const month = document.querySelector('select[name="month"]');
    const gender = document.querySelector('select[name="gender"]');
    const recommend = document.querySelector('select[name="is_recommend"]');
    const emergency = document.querySelector('select[name="is_emergency"]');
    const treatment = document.querySelector('select[name="is_treatment"]');
    const investigated = document.querySelector(
        'select[name="is_investigated"]',
    );

    function hasFilter() {
        return (
            (year && year.value !== "") ||
            (month && month.value !== "") ||
            (gender && gender.value !== "") ||
            (recommend && recommend.value !== "") ||
            (emergency && emergency.value !== "") ||
            (treatment && treatment.value !== "") ||
            (investigated && investigated.value !== "")
        );
    }

    $("#filterForm").on("change", "select,input", function () {
        if (!hasFilter()) {
            const modal = document.getElementById("filterWarningModal");

            if (modal) {
                new bootstrap.Modal(modal).show();
            }

            return;
        }

        $("#filterForm").trigger("submit");
    });

    if (typeof updateSelectedArray === "function") {
        updateSelectedArray();
    }
});
