let selectedRows = [];
let lastChecked = null;

function updateSelectedArray() {
    selectedRows = [];

    $(".row-checkbox:checked").each(function () {
        selectedRows.push($(this).val());
    });

    toggleSelectedButtons();
}

$(document).on("click", ".row-checkbox", function (e) {
    let checkboxes = $(".row-checkbox");
    let currentIndex = checkboxes.index(this);

    if (!lastChecked) {
        lastChecked = this;
    }

    if (e.shiftKey) {
        let lastIndex = checkboxes.index(lastChecked);
        let start = Math.min(lastIndex, currentIndex);
        let end = Math.max(lastIndex, currentIndex);

        checkboxes.slice(start, end + 1).prop("checked", lastChecked.checked);
    }

    lastChecked = this;

    updateSelectedArray();
});

$("#selectAll").on("change", function () {
    $(".row-checkbox").prop("checked", this.checked);

    updateSelectedArray();
});
