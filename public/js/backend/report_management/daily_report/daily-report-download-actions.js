window.DailyReport = window.DailyReport || {};

window.DailyReport.initDownloadActions = function () {
    $("#downloadSelectedPdf").on("click", function (e) {
        e.preventDefault();

        if (window.DailyReport.selectedRows.length === 0) {
            alert("Please select rows");
            return;
        }

        let params = new URLSearchParams($("#filterForm").serialize());

        window.DailyReport.selectedRows.forEach((id) => {
            params.append("ids[]", id);
        });

        if (window.dailyReportRoutes && window.dailyReportRoutes.pdf) {
            window.open(
                window.dailyReportRoutes.pdf + "?" + params.toString(),
                "_blank",
            );
        }
    });

    $("#downloadSelectedExcel").on("click", function (e) {
        e.preventDefault();

        if (window.DailyReport.selectedRows.length === 0) {
            alert("Please select rows");
            return;
        }

        let params = new URLSearchParams($("#filterForm").serialize());

        window.DailyReport.selectedRows.forEach((id) => {
            params.append("ids[]", id);
        });

        if (window.dailyReportRoutes && window.dailyReportRoutes.excel) {
            window.location.href =
                window.dailyReportRoutes.excel + "?" + params.toString();
        }
    });
};
