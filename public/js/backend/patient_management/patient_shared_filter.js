$(function () {
    let table = null;

    if (window.patientTable) {
        table = window.patientTable;
    } else if (window.recommendTable) {
        table = window.recommendTable;
    }

    if (!table) {
        return;
    }

    function reloadTable() {
        table.ajax.reload(null, false);
    }

    function debounce(fn, delay) {
        let timer;

        return function () {
            clearTimeout(timer);
            timer = setTimeout(fn, delay);
        };
    }

    const debouncedReload = debounce(reloadTable, 300);

    const form = $("#patientFilterForm");

    form.on("change", "select", reloadTable);

    form.on("change", "input[type='date']", reloadTable);

    form.on("keyup", "input[type='text']", debouncedReload);
});
