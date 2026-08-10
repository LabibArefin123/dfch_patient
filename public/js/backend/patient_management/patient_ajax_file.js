$(function () {
    const table = $("#patientsTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: {
            url: window.patientRoutes.index,

            data: function (d) {
                /*
                |--------------------------------------------------------------------------
                | NORMAL FILTERS
                |--------------------------------------------------------------------------
                */

                d.gender = $("select[name='gender']").val();

                d.location_type = $("select[name='location_type']").val();
                d.location_value = $("input[name='location_value']").val();

                d.is_referred = $("select[name='is_referred']").val();
                d.is_emergency = $("select[name='is_emergency']").val();
                d.is_treatment = $("select[name='is_treatment']").val();
                d.is_investigated = $("select[name='is_investigated']").val();
                d.is_old_cancer = $("select[name='is_old_cancer']").val();

                d.date_filter = $("select[name='date_filter']").val();
                d.from_date = $("input[name='from_date']").val();
                d.to_date = $("input[name='to_date']").val();

                /*
                |--------------------------------------------------------------------------
                | AGE FILTER
                |--------------------------------------------------------------------------
                */

                d.age_group = window.patientAgeFilter || "";
            },

            dataSrc: function (json) {
                /*
                |--------------------------------------------------------------------------
                | UPDATE AGE COUNTERS
                |--------------------------------------------------------------------------
                */

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
            {
                data: "patient_code",
            },
            {
                data: "name",
            },
            {
                data: "age",
            },
            {
                data: "gender",
            },
            {
                data: "phone",
            },
            {
                data: "location",
                orderable: false,
                searchable: false,
            },
            {
                data: "is_referred",
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
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    /*
    |--------------------------------------------------------------------------
    | MAKE TABLE AVAILABLE GLOBALLY
    |--------------------------------------------------------------------------
    */

    window.patientTable = table;

    /*
    |--------------------------------------------------------------------------
    | NORMAL FILTER CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on(
        "change",
        [
            "select[name='gender']",
            "select[name='location_type']",
            "select[name='is_referred']",
            "select[name='is_emergency']",
            "select[name='is_treatment']",
            "select[name='is_investigated']",
            "select[name='is_old_cancer']",
            "select[name='date_filter']",
        ].join(","),
        function () {
            table.ajax.reload(null, true);
        },
    );

    /*
    |--------------------------------------------------------------------------
    | LOCATION VALUE CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("input", "input[name='location_value']", function () {
        clearTimeout(window.patientLocationTimer);

        window.patientLocationTimer = setTimeout(function () {
            table.ajax.reload(null, true);
        }, 400);
    });

    /*
    |--------------------------------------------------------------------------
    | CUSTOM DATE CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on(
        "change",
        "input[name='from_date'], input[name='to_date']",
        function () {
            if ($("select[name='date_filter']").val() === "custom") {
                table.ajax.reload(null, true);
            }
        },
    );
});
