$(document).ready(function () {
    let printType = "whole";

    $(document).on("click", "#openWholePrintPreview", function () {
        printType = "whole";
        $("#printPreviewModal").modal("show");
        generatePrintCards();
    });

    $(document).on("change", "#cardPrintCopies", function () {
        generatePrintCards();
    });

    function generatePrintCards() {
        let copies = parseInt($("#cardPrintCopies").val());
        let grid = $("#printCardGrid");
        grid.empty();
        let source = $(".card-preview-middle").first();
        if (!source.length) {
            console.error("Whole card not found");
            return;
        }

        for (let i = 1; i <= copies; i++) {
            let clone = source.clone(true, true);
            clone.addClass("print-clone-card");
            let wrapper = $("<div>", {
                class: "print-card-item",
            });
            wrapper.append(clone);
            grid.append(wrapper);
        }
        resizePrintCards();
    }

    function resizePrintCards() {
        $(".print-clone-card").each(function () {
            $(this).css({
                transform: "scale(0.38)",
                transformOrigin: "top center",
            });
        });
    }

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
