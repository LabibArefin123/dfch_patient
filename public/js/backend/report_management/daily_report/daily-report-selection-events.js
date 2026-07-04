window.DailyReport = window.DailyReport || {};

window.DailyReport.initSelectionEvents = function () {
    $(document).on("click", ".row-checkbox", function (e) {
        let checkboxes = $(".row-checkbox");
        let currentIndex = checkboxes.index(this);

        if (!window.DailyReport.lastChecked) {
            window.DailyReport.lastChecked = this;
        }

        if (e.shiftKey) {
            let lastIndex = checkboxes.index(window.DailyReport.lastChecked);
            let start = Math.min(lastIndex, currentIndex);
            let end = Math.max(lastIndex, currentIndex);

            checkboxes
                .slice(start, end + 1)
                .prop("checked", window.DailyReport.lastChecked.checked);
        }

        window.DailyReport.lastChecked = this;
        window.DailyReport.updateSelectedArray();
    });

    $("#selectAll").on("change", function () {
        $(".row-checkbox").prop("checked", this.checked);
        window.DailyReport.updateSelectedArray();
    });
};
