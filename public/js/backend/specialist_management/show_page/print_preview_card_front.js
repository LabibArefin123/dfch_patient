$(document).ready(function () {
    /*
    |--------------------------------------------------------------------------
    | OPEN FRONT CARD PRINT PREVIEW
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#openFrontPrintPreview", function () {
        $("#printPreviewModal").modal("show");

        generateFrontPrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | COPY CHANGE UPDATE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#cardPrintCopies", function () {
        generateFrontPrintCards();
    });

    /*
    |--------------------------------------------------------------------------
    | GENERATE FRONT CARD COPIES
    |--------------------------------------------------------------------------
    */

    function generateFrontPrintCards() {
        let copies = parseInt($("#cardPrintCopies").val());

        let grid = $("#printCardGrid");

        grid.empty();

        /*
        FRONT CARD SOURCE
        */

        let source = $(".doctor-card").first();

        if (!source.length) {
            console.error("Front card not found");

            return;
        }

        /*
        CREATE COPIES
        */

        for (let i = 1; i <= copies; i++) {
            let clone = source.clone(true, true);

            clone.addClass("print-clone-card");

            let wrapper = $("<div>", {
                class: "print-card-item",
            });

            wrapper.append(clone);

            grid.append(wrapper);
        }

        resizeFrontPrintCards();
    }

    /*
    |--------------------------------------------------------------------------
    | FRONT CARD SCALE
    |--------------------------------------------------------------------------
    */

    function resizeFrontPrintCards() {
        $(".print-clone-card").each(function () {
            $(this).css({
                transform: "scale(0.38)",

                transformOrigin: "top center",
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | PRINT BUTTON
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#printCardButton", function () {
        generateFrontPrintCards();

        setTimeout(function () {
            window.print();
        }, 500);
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL OPEN REFRESH
    |--------------------------------------------------------------------------
    */

    $("#printPreviewModal").on("shown.bs.modal", function () {
        generateFrontPrintCards();
    });
});
