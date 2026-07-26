$(function () {
    if (!window.patientTable) {
        return;
    }

    const table = window.patientTable;

    function reloadPatients() {
        table.ajax.reload(null, false);
    }

    // Select2 / Select
    $("#patientFilterForm").on("change", "select", reloadPatients);

    // Text inputs
    $("#patientFilterForm").on(
        "keyup",
        "input[type=text]",
        debounce(reloadPatients, 400),
    );

    // Date inputs
    $("#patientFilterForm").on("change", "input[type=date]", reloadPatients);
});

function debounce(callback, delay) {
    let timer;

    return function () {
        clearTimeout(timer);

        timer = setTimeout(() => {
            callback();
        }, delay);
    };
}
