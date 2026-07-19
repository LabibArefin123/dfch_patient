$(document).on("keyup", "#patientCardSearch", function () {
    clearTimeout(window.patientCard.timer);

    const search = $(this).val();

    window.patientCard.timer = setTimeout(function () {
        loadPatientCards(1, search);
    }, 300);
});
