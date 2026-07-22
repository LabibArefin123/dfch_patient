$(function () {
    const table = $("#patientsTable").DataTable({
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
                d.is_old_cancer = $("select[name=is_old_cancer]").val();
            },

            dataSrc: function (json) {
                $("#childCount").text(json.childPatients ?? 0);
                $("#adultCount").text(json.adultPatients ?? 0);
                $("#seniorCount").text(json.seniorPatients ?? 0);

                return json.data;
            },
        },

        columns: [
            {
                data: "checkbox",
                orderable: false,
                searchable: false,
            },
            {
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            {
                data: "photo",
                orderable: false,
                searchable: false,
            },
            {
                data: "emergency",
                orderable: false,
                searchable: false,
            },
            { data: "patient_code" },
            { data: "name" },
            { data: "age" },
            { data: "gender" },
            { data: "phone" },
            {
                data: "location",
                orderable: false,
                searchable: false,
            },
            { data: "is_recommend" },
            {
                data: "treatment",
            },
            {
                data: "investigation",
                
            },
            {
                data: "does_old_cancer",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_cancer_photos",
                orderable: false,
                searchable: false,
            },
            { data: "date" },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    window.patientTable = table;

    $("#patientFilterForm").on("submit", function (e) {
        e.preventDefault();

        table.ajax.reload();
    });
});
