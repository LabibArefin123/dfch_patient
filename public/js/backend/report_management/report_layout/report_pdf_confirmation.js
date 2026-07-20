(function ($) {
    "use strict";

    window.ReportPdfConfirmation = {
        init: function () {
            const modal = $("#warningMessage");

            if (!modal.length) {
                return;
            }

            const pdfParams = window.reportConfig.pdfParams;

            console.log(
                "Raw PDF Params:",

                pdfParams,
            );

            modal.modal("show");

            $("#confirmPdfBtn").on(
                "click",

                function () {
                    try {
                        const cleanParams = {};

                        Object.keys(pdfParams)

                            .forEach(function (key) {
                                const value = pdfParams[key];

                                if (
                                    value !== null &&
                                    value !== "null" &&
                                    value !== "" &&
                                    key !== "totalRecords" &&
                                    key !== "perPage"
                                ) {
                                    cleanParams[key] = value;
                                }
                            });

                        const params = new URLSearchParams(cleanParams);

                        params.set(
                            "confirm",

                            1,
                        );

                        const finalUrl =
                            window.reportConfig.pdfRoute +
                            "?" +
                            params.toString();

                        console.log(
                            "Cleaned URL:",

                            finalUrl,
                        );

                        window.open(
                            finalUrl,

                            "_blank",
                        );

                        modal.modal("hide");
                    } catch (error) {
                        console.error(
                            "Confirm PDF Error:",

                            error,
                        );
                    }
                },
            );
        },
    };
})(jQuery);
