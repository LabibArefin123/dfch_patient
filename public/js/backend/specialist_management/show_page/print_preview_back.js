$(document).ready(function () {
    $(document).on("click", "#openBackPrintPreview", function () {
        window.printType = "back";

        $("#printPreviewModal").modal("show");

        generatePrintCards();
    });
});
