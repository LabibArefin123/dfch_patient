$(function () {
    var table = $("#patientsTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: window.patientRoutes.index,
            data: function (d) {
                d.gender = $("select[name=gender]").val();
                d.is_recommend = $("select[name=is_recommend]").val();
                d.location_type = $("select[name=location_type]").val();
                d.location_value = $("input[name=location_value]").val();
                d.date_filter = $("select[name=date_filter]").val();
                d.from_date = $("input[name=from_date]").val();
                d.to_date = $("input[name=to_date]").val();
            },
            dataSrc: function (json) {
                $("#childCount").text(json.childPatients ?? 0);
                $("#adultCount").text(json.adultPatients ?? 0);
                $("#seniorCount").text(json.seniorPatients ?? 0);
                return json.data;
            },
        },
        columns: [
            { data: "checkbox", name: "checkbox" },
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "patient_code", name: "patient_code" },
            { data: "name", name: "patient_name" },
            { data: "age", name: "age" },
            { data: "gender", name: "gender" },
            { data: "phone", name: "phone_1" },
            { data: "location", orderable: false, searchable: false },
            { data: "is_recommend", name: "is_recommend" },
            { data: "date", name: "date_of_patient_added" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    // Filter submit
    $("form").on("submit", function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
