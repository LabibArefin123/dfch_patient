$(function () {
    const table = $("#patientsRefTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: {
            url: window.recommendRoutes.recommend,

            data: function (d) {
                /* Basic Filters*/
                d.gender = $("select[name='gender']").val();
                d.location_type = $("select[name='location_type']").val();
                d.location_value = $("input[name='location_value']").val();

                /*Patient Status  */
                d.is_referred = $("select[name='is_referred']").val();
                d.is_emergency = $("select[name='is_emergency']").val();
                d.is_treatment = $("select[name='is_treatment']").val();
                d.is_investigated = $("select[name='is_investigated']").val();
                d.is_old_cancer = $("select[name='is_old_cancer']").val();

                /* Date */
                d.date_filter = $("select[name='date_filter']").val();
                d.from_date = $("input[name='from_date']").val();
                d.to_date = $("input[name='to_date']").val();

                /*AGE FILTER */
                d.age_group = window.patientAgeFilter || "";
            },

            /* Response*/
            dataSrc: function (json) {
                /* IMPORTANT:Update only the <strong> number. */
                $("#childCount strong").text(json.childPatients ?? 0);
                $("#adultCount strong").text(json.adultPatients ?? 0);
                $("#seniorCount strong").text(json.seniorPatients ?? 0);
                return json.data || [];
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
                data: "is_referred",
                name: "is_referred",
            },
            {
                data: "emergency",
                orderable: false,
                searchable: false,
            },
            {
                data: "treatment",
                orderable: false,
                searchable: false,
            },
            {
                data: "investigation",
                orderable: false,
                searchable: false,
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

    window.recommendTable = table;
});
