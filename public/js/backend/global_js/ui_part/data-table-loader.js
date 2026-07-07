$(document).ready(function () {
    const table = $("#dataTables");

    // Safety check: only initialize if target table exists on the DOM
    if (table.length > 0) {
        table.DataTable();
    }
});
