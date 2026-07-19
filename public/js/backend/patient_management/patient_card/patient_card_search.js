$(document).on("keyup", "#patientCardSearch", function () {
    clearTimeout(window.patientCard.searchTimer);

    const search = $(this).val();

    window.patientCard.searchTimer = setTimeout(function () {
        loadPatientCards(1, search);
    }, 350);
});
