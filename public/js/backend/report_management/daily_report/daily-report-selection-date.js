window.DailyReport = window.DailyReport || {};

window.DailyReport.selectedRows = [];
window.DailyReport.lastChecked = null;

window.DailyReport.updateSelectedArray = function () {
    window.DailyReport.selectedRows = [];

    $(".row-checkbox:checked").each(function () {
        window.DailyReport.selectedRows.push($(this).val());
    });

    window.DailyReport.toggleSelectedButtons();
};

window.DailyReport.toggleSelectedButtons = function () {
    if (window.DailyReport.selectedRows.length > 0) {
        $("#downloadSelectedPdf").removeClass("d-none");
        $("#downloadSelectedExcel").removeClass("d-none");
    } else {
        $("#downloadSelectedPdf").addClass("d-none");
        $("#downloadSelectedExcel").addClass("d-none");
    }
};
