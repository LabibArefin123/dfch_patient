$(function () {
    /**
     * Reload DataTable
     */
    function reloadPatientTable() {
        if (window.patientTable) {
            window.patientTable.ajax.reload(null, true);
        }
    }

    /**
     * Select Filters
     */
    $(
        "select[name='gender'],\
        select[name='location_type'],\
        select[name='is_referred'],\
        select[name='is_emergency'],\
        select[name='is_treatment'],\
        select[name='is_investigated'],\
        select[name='is_old_cancer'],\
        select[name='date_filter']",
    ).on("change", function () {
        reloadPatientTable();
    });

    /**
     * Location Search
     */
    $("input[name='location_value']").on("keyup", function () {
        reloadPatientTable();
    });

    /**
     * Custom Date
     */
    $("input[name='from_date'], input[name='to_date']").on(
        "change",
        function () {
            reloadPatientTable();
        },
    );

    /**
     * Global Search (DataTable Search Box)
     */
    $(document).on("keyup", "#patientsTable_filter input", function () {
        window.patientTable.search($(this).val()).draw();
    });
});
