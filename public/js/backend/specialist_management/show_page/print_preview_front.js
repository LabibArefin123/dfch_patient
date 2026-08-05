$(document).ready(function () {
    $(document).on("click", "#openFrontPrintPreview", function () {
        window.printType = "front";

        $("#printPreviewModal").modal("show");

        generatePrintCards();
    });
});
