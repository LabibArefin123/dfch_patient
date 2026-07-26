$(function () {
    if (!window.recommendTable) {
        return;
    }

    const table = window.recommendTable;

    function reloadTable() {
        table.ajax.reload(null, false);
    }

    $("#patientFilterForm").on("change", "select", reloadTable);

    $("#patientFilterForm").on("change", "input[type='date']", reloadTable);

    $("#patientFilterForm").on(
        "keyup",
        "input[type='text']",
        debounce(reloadTable, 400),
    );
});

function debounce(callback, delay) {
    let timer;

    return function () {
        clearTimeout(timer);

        timer = setTimeout(function () {
            callback();
        }, delay);
    };
}
