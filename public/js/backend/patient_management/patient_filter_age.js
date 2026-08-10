$(function () {
    /*
    |--------------------------------------------------------------------------
    | INITIAL AGE FILTER
    |--------------------------------------------------------------------------
    */

    window.patientAgeFilter = "";

    /*
    |--------------------------------------------------------------------------
    | CLICK CHILD
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#childCount", function (e) {
        e.preventDefault();

        if (window.patientAgeFilter === "child") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "child";
        }

        reloadPatientTable();
        updateActiveAgeFilter();
    });

    /*
    |--------------------------------------------------------------------------
    | CLICK ADULT
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#adultCount", function (e) {
        e.preventDefault();

        if (window.patientAgeFilter === "adult") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "adult";
        }

        reloadPatientTable();
        updateActiveAgeFilter();
    });

    /*
    |--------------------------------------------------------------------------
    | CLICK SENIOR
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#seniorCount", function (e) {
        e.preventDefault();

        if (window.patientAgeFilter === "senior") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "senior";
        }

        reloadPatientTable();
        updateActiveAgeFilter();
    });

    /*
    |--------------------------------------------------------------------------
    | RELOAD TABLE
    |--------------------------------------------------------------------------
    */

    function reloadPatientTable() {
        if (!window.patientTable) {
            console.warn("Patient DataTable not found.");
            return;
        }

        window.patientTable.ajax.reload(null, false);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVE FILTER STYLE
    |--------------------------------------------------------------------------
    */

    function updateActiveAgeFilter() {
        $("#childCount, #adultCount, #seniorCount").removeClass(
            "age-filter-active",
        );

        if (window.patientAgeFilter === "child") {
            $("#childCount").addClass("age-filter-active");
        }

        if (window.patientAgeFilter === "adult") {
            $("#adultCount").addClass("age-filter-active");
        }

        if (window.patientAgeFilter === "senior") {
            $("#seniorCount").addClass("age-filter-active");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR AGE FILTER WHEN NORMAL FILTER CHANGES
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
            window.patientAgeFilter = "";

            updateActiveAgeFilter();
        },
    );

    /*
    |--------------------------------------------------------------------------
    | CLEAR AGE FILTER WHEN LOCATION CHANGES
    |--------------------------------------------------------------------------
    */

    $(document).on("input", "input[name='location_value']", function () {
        window.patientAgeFilter = "";

        updateActiveAgeFilter();
    });

    /*
    |--------------------------------------------------------------------------
    | CLEAR AGE FILTER WHEN CUSTOM DATE CHANGES
    |--------------------------------------------------------------------------
    */

    $(document).on(
        "change",
        "input[name='from_date'], input[name='to_date']",
        function () {
            if ($("select[name='date_filter']").val() === "custom") {
                window.patientAgeFilter = "";

                updateActiveAgeFilter();
            }
        },
    );
});
