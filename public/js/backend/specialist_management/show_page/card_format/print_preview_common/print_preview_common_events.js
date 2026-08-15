(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};
    window.patientPrintPreview = window.patientPrintPreview || {};

    const Print = window.patientCardPrint;
    const Preview = window.patientPrintPreview;

    /*
    |--------------------------------------------------------------------------
    | OPEN PREVIEW
    |--------------------------------------------------------------------------
    */

    Print.open = function (mode) {
        if (!["front", "back", "whole"].includes(mode)) {
            console.error("Invalid print preview mode:", mode);
            return false;
        }

        const modal = $("#printPreviewModal");

        if (!modal.length) {
            console.error("#printPreviewModal not found.");

            return false;
        }

        /*
        | Save mode BEFORE generation
        */

        Print.mode = mode;
        Preview.mode = mode;

        /*
        | Generate preview
        */

        if (typeof Print.generate !== "function") {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        const generated = Print.generate(mode);

        if (generated === false) {
            console.error("Failed to generate:", mode);

            return false;
        }

        /*
        | Open modal
        */

        try {
            modal.modal({
                backdrop: false,
                keyboard: true,
                show: true,
            });
        } catch (error) {
            console.error("Bootstrap modal error:", error);

            modal
                .addClass("show")
                .attr("aria-hidden", "false")
                .css("display", "block");

            $("body").addClass("modal-open");
        }

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | FRONT
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("click.specialistPrintFront", "#openFrontPrintPreview")
        .on(
            "click.specialistPrintFront",
            "#openFrontPrintPreview",
            function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Print.open("front");

                return false;
            },
        );

    /*
    |--------------------------------------------------------------------------
    | BACK
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("click.specialistPrintBack", "#openBackPrintPreview")
        .on("click.specialistPrintBack", "#openBackPrintPreview", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            Print.open("back");

            return false;
        });

    /*
    |--------------------------------------------------------------------------
    | WHOLE
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("click.specialistPrintWhole", "#openWholePrintPreview")
        .on(
            "click.specialistPrintWhole",
            "#openWholePrintPreview",
            function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Print.open("whole");

                return false;
            },
        );

    /*
    |--------------------------------------------------------------------------
    | COPIES
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("change.specialistPrintCopies", "#cardPrintCopies")
        .on("change.specialistPrintCopies", "#cardPrintCopies", function () {
            if (!Print.mode) {
                return;
            }

            Print.generate(Print.mode);
        });

    /*
    |--------------------------------------------------------------------------
    | THEME
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("change.specialistPrintTheme", "#card_theme")
        .on("change.specialistPrintTheme", "#card_theme", function () {
            if (!Print.mode) {
                return;
            }

            Print.generate(Print.mode);
        });

    /*
    |--------------------------------------------------------------------------
    | PRINT BUTTON
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("click.specialistPrintButton", "#printCardButton")
        .on("click.specialistPrintButton", "#printCardButton", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const mode = Print.mode || Preview.mode;

            if (!mode) {
                console.error("No print mode selected.");

                return false;
            }

            if (typeof Preview.print !== "function") {
                console.error("patientPrintPreview.print() is not available.");

                return false;
            }

            Preview.print(mode);

            return false;
        });

    /*
    |--------------------------------------------------------------------------
    | MODAL SHOWN
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("shown.bs.modal.specialistPrint", "#printPreviewModal")
        .on(
            "shown.bs.modal.specialistPrint",
            "#printPreviewModal",
            function () {
                if (!Print.mode) {
                    return;
                }

                setTimeout(function () {
                    Print.generate(Print.mode);
                }, 50);
            },
        );

    /*
    |--------------------------------------------------------------------------
    | MODAL CLOSED
    |--------------------------------------------------------------------------
    */

    $(document)
        .off("hidden.bs.modal.specialistPrint", "#printPreviewModal")
        .on(
            "hidden.bs.modal.specialistPrint",
            "#printPreviewModal",
            function () {
                if (typeof Print.clearGrid === "function") {
                    Print.clearGrid();
                }

                Print.mode = null;
                Preview.mode = null;
                Preview.isPrinting = false;

                setTimeout(function () {
                    $(".modal-backdrop").remove();

                    $("body").removeClass("modal-open").css({
                        paddingRight: "",
                        overflow: "",
                    });
                }, 100);
            },
        );
})(window, jQuery);
