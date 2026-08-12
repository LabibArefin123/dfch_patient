$(function () {
    $(document).on("click", "#openWholePrintPreview", function (e) {
        e.preventDefault();
        window.patientCardPrint.open("whole");
    });
});
