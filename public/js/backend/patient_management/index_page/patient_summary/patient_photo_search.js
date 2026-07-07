$("#patientPhotoBtn").click(function () {
    $("#patientPhotoInput").click();
});

$("#patientPhotoInput").change(function () {
    let fd = new FormData();

    fd.append("photo", this.files[0]);

    fd.append("_token", $("meta[name=csrf-token]").attr("content"));

    $.ajax({
        url: patientPhotoSearchUrl,

        type: "POST",

        data: fd,

        processData: false,

        contentType: false,

        success: function (res) {
            renderPatientResults(res.patients);
        },
    });
});
