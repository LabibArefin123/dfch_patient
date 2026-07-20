(function ($, window) {
    "use strict";

    console.log("[REPORT][STAGE 17] report_filters.js loaded");

    window.ReportFilters = {
        init: function () {
            console.log("[REPORT][STAGE 18] Filter initialization started");

            const form = $("#filterForm");

            if (!form.length) {
                console.warn("[REPORT][WARNING] #filterForm not found");

                return;
            }

            form.on("submit", function (e) {
                e.preventDefault();

                console.log("[REPORT][STAGE 19] Filter form submitted");

                if (window.ReportDataTable) {
                    ReportDataTable.reload();
                }
            });

            console.log("[REPORT][STAGE 20] Filter form initialized");
        },
    };
})(jQuery, window);
