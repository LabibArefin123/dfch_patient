/*PATIENT AGE FILTER*/

$(function () {
    /*INITIAL AGE FILTER */
    window.patientAgeFilter = "";

    /* GET ACTIVE TABLE  */
    function getPatientAgeTable() {
        /* Normal Patient Index */

        if (
            window.patientTable &&
            $.fn.DataTable.isDataTable("#patientsTable")
        ) {
            return window.patientTable;
        }

        /* Recommend Patient Index*/
        if (
            window.recommendTable &&
            $.fn.DataTable.isDataTable("#patientsRefTable")
        ) {
            return window.recommendTable;
        }

        return null;
    }

    /*RELOAD TABLE*/
    function reloadPatientTable() {
        const table = getPatientAgeTable();

        if (!table) {
            console.warn("Patient DataTable not found.");

            return;
        }

        table.ajax.reload(null, false);
    }

    /* CHILD */
    $(document).on("click", "#childCount", function () {
        if (window.patientAgeFilter === "child") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "child";
        }

        updateActiveAgeFilter();
        reloadPatientTable();
    });

    /*ADULT */
    $(document).on("click", "#adultCount", function () {
        if (window.patientAgeFilter === "adult") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "adult";
        }

        updateActiveAgeFilter();
        reloadPatientTable();
    });

    /* SENIOR*/
    $(document).on("click", "#seniorCount", function () {
        if (window.patientAgeFilter === "senior") {
            window.patientAgeFilter = "";
        } else {
            window.patientAgeFilter = "senior";
        }

        updateActiveAgeFilter();
        reloadPatientTable();
    });

    /*ACTIVE AGE FILTER STYLE */
    function updateActiveAgeFilter() {
        $("#childCount, " + "#adultCount, " + "#seniorCount").removeClass(
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

    /*CLEAR AGE FILTER*/
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

    /* LOCATION INPUT*/

    $(document).on("input", "input[name='location_value']", function () {
        window.patientAgeFilter = "";

        updateActiveAgeFilter();
    });

    /*CUSTOM DATE */
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
