$(document).ready(function () {
    // ==========================================
    // Read date_filter from URL
    // ==========================================
    const urlParams = new URLSearchParams(window.location.search);
    const urlDateFilter = urlParams.get("date_filter");

    if (urlDateFilter) {
        $("select[name='date_filter']").val(urlDateFilter);
    }

    // ==========================================
    // Initialize DataTable
    // ==========================================
    const table = $("#patientsRefTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: {
            url: window.recommendRoutes.recommend,

            data: function (d) {
                /* Basic Filters */
                d.gender = $("select[name='gender']").val();

                d.location_type = $("select[name='location_type']").val();
                d.location_value = $("input[name='location_value']").val();

                /* Patient Status Filters */
                d.is_recommend = $("select[name='is_recommend']").val();
                d.is_emergency = $("select[name='is_emergency']").val();
                d.is_treatment = $("select[name='is_treatment']").val();
                d.is_investigated = $("select[name='is_investigated']").val();
                d.is_old_cancer = $("select[name='is_old_cancer']").val();

                /* Date Filters */
                d.from_date = $("input[name='from_date']").val();
                d.to_date = $("input[name='to_date']").val();

                // Respect dropdown first, otherwise URL parameter
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
                data: "patient_code",
                name: "patient_code",
            },
            {
                data: "name",
                name: "patient_name",
            },
            {
                data: "age",
                name: "age",
            },
            {
                data: "gender",
                name: "gender",
            },
            {
                data: "phone",
                name: "phone_1",
            },
            {
                data: "location",
                orderable: false,
                searchable: false,
            },
            {
                data: "is_recommend",
                name: "is_recommend",
            },
            {
                data: "emergency",
                orderable: false,
                searchable: false,
            },
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
            {
                data: "date",
                name: "date_of_patient_added",
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    // ==========================================
    // Filter Submit
    // ==========================================
    $("#patientFilterForm").on("submit", function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
