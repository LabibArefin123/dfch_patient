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
        let copies = parseInt($("#cardPrintCopies").val()) || 1;

        let grid = $("#printCardGrid");

        grid.empty();

        // Only clone the front doctor card
        let source = $(".doctor-card").first();

        if (!source.length) {
            console.error("Doctor card not found.");
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

        resizeFrontPrintCards();
    }

    /*
    |--------------------------------------------------------------------------
    | FRONT CARD SCALE
    |--------------------------------------------------------------------------
    */

    function resizeFrontPrintCards() {
        $(".print-clone-card").css({
            transform: "scale(0.36)",
            transformOrigin: "top center",
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
    | MODAL REFRESH
    |--------------------------------------------------------------------------
    */

    $("#printPreviewModal").on("shown.bs.modal", function () {
        generateFrontPrintCards();
    });
});
