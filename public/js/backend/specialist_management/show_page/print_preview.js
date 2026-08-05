$(document).ready(function () {
    let printType = "front";

    /*
    |--------------------------------------------------------------------------
    | OPEN FRONT
    |--------------------------------------------------------------------------
    */
    $(document).on("click", "#openFrontPrintPreview", function () {
        printType = "front";
        $("#printPreviewModal").modal("show");
        generatePrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN BACK
    |--------------------------------------------------------------------------
    */
    $(document).on("click", "#openBackPrintPreview", function () {
        printType = "back";
        $("#printPreviewModal").modal("show");
        generatePrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN WHOLE
    |--------------------------------------------------------------------------
    */
    $(document).on("click", "#openWholePrintPreview", function () {
        printType = "whole";
        $("#printPreviewModal").modal("show");
        generatePrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | COPIES CHANGE
    |--------------------------------------------------------------------------
    */
    $(document).on("change", "#cardPrintCopies", function () {
        generatePrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | GENERATE PRINT CARDS
    |--------------------------------------------------------------------------
    */
    function generatePrintCards() {
        let copies = parseInt($("#cardPrintCopies").val()) || 1;

        let grid = $("#printCardGrid");

        grid.empty();

        let source;

        switch (printType) {
            case "front":
                source = $(".doctor-card").first();
                break;

            case "back":
                source = $(".doctor-card-holder").first();
                break;

            case "whole":
                source = $(".card-preview-middle").first();
                break;

            default:
                return;
        }

        if (!source.length) {
            console.error(printType + " source not found.");
            return;
        }

        for (let i = 0; i < copies; i++) {
            let clone = source.clone(false);

            clone.removeAttr("id").addClass("print-clone-card");

            let wrapper = $("<div>", {
                class: "print-card-item",
            });

            wrapper.append(clone);

            grid.append(wrapper);
        }

        resizePrintCards();
    }

    /*
    |--------------------------------------------------------------------------
    | SCALE
    |--------------------------------------------------------------------------
    */
    function resizePrintCards() {
        let scale = 0.38;

        if (printType === "front") {
            scale = 0.36;
        }

        $(".print-clone-card").css({
            transform: "scale(" + scale + ")",
            transformOrigin: "top center",
        });
    }

    /*
    |--------------------------------------------------------------------------
    | PRINT
    |--------------------------------------------------------------------------
    */
    $(document).on("click", "#printCardButton", function () {
        generatePrintCards();

        setTimeout(function () {
            window.print();
        }, 500);
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL REFRESH
    |--------------------------------------------------------------------------
    */
    $("#printPreviewModal").on("shown.bs.modal", function () {
        generatePrintCards();
    });
});
