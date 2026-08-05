$(document).ready(function () {
    $(document).on("click", "#openWholePrintPreview", function () {
        window.printType = "whole";

        $("#printPreviewModal").modal("show");

        generatePrintCards();
    });
});
