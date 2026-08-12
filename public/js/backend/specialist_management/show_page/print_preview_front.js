$(function () {
    $(document).on("click", "#openFrontPrintPreview", function (e) {
        e.preventDefault();
        window.patientCardPrint.open("front");
    });
    $(document).on("click", "#printCardButton", function (e) {
        e.preventDefault();
        window.patientCardPrint.generate("front");
        setTimeout(function () {
            window.print();
        }, 500);
    });
});
