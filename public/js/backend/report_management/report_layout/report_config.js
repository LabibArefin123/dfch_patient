(function (window) {
    "use strict";

    console.log("[REPORT][STAGE 1] report_config.js loaded");

    window.ReportConfig = {
        dataTableUrl: null,

        pdfRoute: null,

        excelRoute: null,

        columns: [],

        pdfParams: {},
    };

    window.ReportConfig.init = function (config) {
        console.log(
            "[REPORT][STAGE 2] Initializing report configuration",
            config,
        );

        if (!config) {
            console.error("[REPORT][ERROR] Report configuration is missing");

            return false;
        }

        this.dataTableUrl = config.dataTableUrl || null;

        this.pdfRoute = config.pdfRoute || null;

        this.excelRoute = config.excelRoute || null;

        this.columns = config.columns || [];

        this.pdfParams = config.pdfParams || {};

        console.log("[REPORT][STAGE 3] Report configuration loaded", {
            dataTableUrl: this.dataTableUrl,
            pdfRoute: this.pdfRoute,
            excelRoute: this.excelRoute,
            columns: this.columns,
            pdfParams: this.pdfParams,
        });

        if (!this.dataTableUrl) {
            console.error("[REPORT][ERROR] DataTable URL is missing");

            return false;
        }

        if (!this.columns.length) {
            console.error("[REPORT][ERROR] DataTable columns are empty");

            return false;
        }

        return true;
    };
})(window);
