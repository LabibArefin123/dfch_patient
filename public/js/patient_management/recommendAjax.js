$(document).ready(function () {
    // ===========================
    // Read date_filter from URL
    // ===========================
    const urlParams = new URLSearchParams(window.location.search);
    const urlDateFilter = urlParams.get("date_filter");

    if (urlDateFilter) {
        $("select[name='date_filter']").val(urlDateFilter);
    }

    // ===========================
    // Initialize DataTable
    // ===========================
    const table = $("#patientsTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: window.recommendRoutes.recommend,
            data: function (d) {
                d.gender = $("select[name='gender']").val();
                d.location_type = $("select[name='location_type']").val();
                d.location_value = $("input[name='location_value']").val();
                d.from_date = $("input[name='from_date']").val();
                d.to_date = $("input[name='to_date']").val();

                // Always respect dropdown OR URL
                d.date_filter =
                    $("select[name='date_filter']").val() || urlDateFilter;
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

    // ===========================
    // Filter Submit
    // ===========================
    $("form").on("submit", function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
