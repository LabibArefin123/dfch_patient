$(document).ready(function () {
    window.printType = "front";

    window.generatePrintCards = function () {
        let copies = parseInt($("#cardPrintCopies").val()) || 1;

        let grid = $("#printCardGrid");

        grid.empty();

        let source;

        switch (window.printType) {
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
            console.error(window.printType + " source not found.");
            return;
        }

        for (let i = 0; i < copies; i++) {
            let clone = source.clone(false);

            clone.removeAttr("id").addClass("print-clone-card");

            $("<div>", {
                class: "print-card-item",
            })
                .append(clone)
                .appendTo(grid);
        }

        resizePrintCards();
    };

    window.resizePrintCards = function () {
        let scale = window.printType === "front" ? 0.36 : 0.38;

        $(".print-clone-card").css({
            transform: `scale(${scale})`,
            transformOrigin: "top center",
        });
    };

    $(document).on("change", "#cardPrintCopies", function () {
        generatePrintCards();
    });

    $(document).on("click", "#printCardButton", function () {
        generatePrintCards();

        setTimeout(function () {
            window.print();
        }, 500);
    });

    $("#printPreviewModal").on("shown.bs.modal", function () {
        generatePrintCards();
    });
});
