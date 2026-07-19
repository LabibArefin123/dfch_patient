$(document).on("click", "#clearPatientCardSearch", function () {
    $("#patientCardSearch").val("").focus();

    loadPatientCards(1, "");
});
