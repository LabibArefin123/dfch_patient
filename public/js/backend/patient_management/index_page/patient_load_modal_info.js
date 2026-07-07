$(document).on("click", ".patient-image-modal-btn", function () {
    $("#modalPatientPhoto").attr("src", $(this).data("photo"));

    $("#modalPatientName").text($(this).data("name"));
    $("#modalPatientCode").text($(this).data("code"));
    $("#modalPatientAge").text($(this).data("age"));
    $("#modalPatientGender").text($(this).data("gender"));
    $("#modalPatientPhone").text($(this).data("phone"));
    $("#modalPatientDate").text($(this).data("date"));

    $("#patientImageModal").modal("show");
});
