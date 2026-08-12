$(function () {
    $(document).on("click", "#openBackPrintPreview", function (e) {
        e.preventDefault();
        window.patientCardPrint.open("back");
    });
});
