(function ($, window) {
    "use strict";

    console.log("[REPORT][STAGE 21] report_export.js loaded");

    window.ReportExport = {
        init: function () {
            console.log("[REPORT][STAGE 22] Export initialization started");

            $("#downloadPdfBtn").on("click", function (e) {
                e.preventDefault();

                console.log("[REPORT][STAGE 23] PDF download clicked");

                const params = $("#filterForm").serialize();

                const url = ReportConfig.pdfRoute + "?" + params;

                console.log("[REPORT][STAGE 24] Opening PDF URL", url);

                window.open(url, "_blank");
            });

            $("#downloadExcelBtn").on("click", function (e) {
                e.preventDefault();

                console.log("[REPORT][STAGE 25] Excel download clicked");

                const params = $("#filterForm").serialize();

                const url = ReportConfig.excelRoute + "?" + params;

                console.log("[REPORT][STAGE 26] Redirecting to Excel URL", url);

                window.location.href = url;
            });

            console.log("[REPORT][STAGE 27] Export buttons initialized");
        },
    };
})(jQuery, window);
