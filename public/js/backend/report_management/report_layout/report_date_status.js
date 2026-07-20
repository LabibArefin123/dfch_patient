(function ($) {
    "use strict";

    console.log("[REPORT][STAGE 28] report_date_status.js loaded");

    window.ReportDateStatus = {
        init: function () {
            console.log(
                "[REPORT][STAGE 29] Date status initialization started",
            );

            $(document).on(
                "change",

                '#week_filter, input[name="from_date"], input[name="to_date"]',

                function () {
                    console.log("[REPORT][STAGE 30] Date filter changed");

                    ReportDateStatus.calculate();
                },
            );

            this.calculate();
        },

        calculate: function () {
            const status = $("#dateStatus");

            if (!status.length) {
                console.log("[REPORT][INFO] #dateStatus not found");

                return;
            }

            const toDateInput = $('input[name="to_date"]');

            if (!toDateInput.length) {
                console.log("[REPORT][INFO] to_date input not found");

                return;
            }

            const toDate = toDateInput.val();

            const dateFilter = $("#week_filter").length
                ? $("#week_filter").val()
                : "custom";

            if (dateFilter !== "custom" || !toDate) {
                status.html("");

                return;
            }

            const today = new Date();

            const selectedDate = new Date(toDate);

            if (isNaN(selectedDate)) {
                console.error("[REPORT][ERROR] Invalid selected date", toDate);

                status.html("");

                return;
            }

            const diffTime = today - selectedDate;

            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                status

                    .removeClass()

                    .addClass("small font-weight-bold text-danger")

                    .html("⚠ You are " + diffDays + " days behind.");
            } else if (diffDays === 0) {
                status

                    .removeClass()

                    .addClass("small font-weight-bold text-success")

                    .html("✔ Viewing today's data.");
            } else {
                const daysAhead = Math.abs(diffDays);

                status

                    .removeClass()

                    .addClass("small font-weight-bold text-info")

                    .html("You are " + daysAhead + " days ahead.");
            }
        },
    };
})(jQuery);
