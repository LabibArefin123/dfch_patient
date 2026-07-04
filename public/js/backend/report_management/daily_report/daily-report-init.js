document.addEventListener("DOMContentLoaded", function () {
    if (!window.DailyReport) {
        console.warn("DailyReport object not found.");
        return;
    }

    if (typeof window.DailyReport.initDateFilter === "function") {
        window.DailyReport.initDateFilter();
    }

    if (typeof window.DailyReport.initSelectionEvents === "function") {
        window.DailyReport.initSelectionEvents();
    }

    if (typeof window.DailyReport.initDownloadActions === "function") {
        window.DailyReport.initDownloadActions();
    }
});
