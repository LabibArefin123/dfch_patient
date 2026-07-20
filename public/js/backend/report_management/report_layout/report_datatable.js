(function ($, window) {
    "use strict";

    console.log("[REPORT][STAGE 4] report_datatable.js loaded");

    window.ReportDataTable = {
        table: null,

        init: function () {
            console.log("[REPORT][STAGE 5] DataTable initialization started");

            const tableElement = $("#reportTable");

            if (!tableElement.length) {
                console.error("[REPORT][ERROR] #reportTable was not found");

                return;
            }

            console.log("[REPORT][STAGE 6] #reportTable found");

            if (!window.ReportConfig) {
                console.error("[REPORT][ERROR] ReportConfig is unavailable");

                return;
            }

            console.log(
                "[REPORT][STAGE 7] DataTable URL:",
                ReportConfig.dataTableUrl,
            );

            console.log(
                "[REPORT][STAGE 8] DataTable columns:",
                ReportConfig.columns,
            );

            try {
                this.table = tableElement.DataTable({
                    processing: true,

                    serverSide: true,

                    responsive: true,

                    ajax: {
                        url: ReportConfig.dataTableUrl,

                        type: "GET",

                        beforeSend: function (xhr, settings) {
                            console.log(
                                "[REPORT][STAGE 9] AJAX request started",
                                {
                                    url: settings.url,
                                    data: settings.data,
                                },
                            );
                        },

                        data: function (d) {
                            console.log(
                                "[REPORT][STAGE 10] Preparing AJAX data",
                                d,
                            );

                            const form = $("#filterForm");

                            if (!form.length) {
                                console.warn(
                                    "[REPORT][WARNING] #filterForm not found",
                                );

                                return d;
                            }

                            form.serializeArray().forEach(function (item) {
                                d[item.name] = item.value;
                            });

                            console.log("[REPORT][STAGE 11] Filters added", d);

                            return d;
                        },

                        dataSrc: function (json) {
                            console.log(
                                "[REPORT][STAGE 12] AJAX success",
                                json,
                            );

                            if (!json) {
                                console.error(
                                    "[REPORT][ERROR] Empty AJAX response",
                                );

                                return [];
                            }

                            if (json.error) {
                                console.error(
                                    "[REPORT][ERROR] Laravel/DataTables error",
                                    json.error,
                                );
                            }

                            return json.data || [];
                        },

                        error: function (xhr, error, thrown) {
                            console.error("[REPORT][AJAX ERROR]", {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                error: error,
                                thrown: thrown,
                                response: xhr.responseText,
                            });
                        },
                    },

                    columns: ReportConfig.columns,

                    initComplete: function (settings, json) {
                        console.log(
                            "[REPORT][STAGE 13] DataTable initialized successfully",
                            json,
                        );
                    },
                });

                console.log("[REPORT][STAGE 14] DataTable instance created");
            } catch (error) {
                console.error(
                    "[REPORT][FATAL ERROR] DataTable initialization failed",
                    error,
                );
            }
        },

        reload: function () {
            console.log("[REPORT][STAGE 15] Reload requested");

            if (!this.table) {
                console.error(
                    "[REPORT][ERROR] Cannot reload. DataTable is not initialized",
                );

                return;
            }

            this.table.ajax.reload(null, false);

            console.log("[REPORT][STAGE 16] DataTable reload completed");
        },
    };
})(jQuery, window);
