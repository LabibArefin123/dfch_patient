function hasFilterApplied() {
    return (
        $('select[name="gender"]').val() ||
        $('select[name="location_type"]').val() ||
        $('input[name="location_value"]').val() ||
        $('select[name="date_filter"]').val() ||
        $('input[name="from_date"]').val() ||
        $('input[name="to_date"]').val()
    );
}

function handleExport(selector, title, text, color) {
    $(document).on("click", selector, function (e) {
        e.preventDefault();

        if (!hasFilterApplied()) {
            $("#noFilterModal").modal("show");
            return;
        }

        let baseUrl = $(this).attr("href");

        let params = {
            gender: $("select[name=gender]").val(),
            is_recommend: $("select[name=is_recommend]").val(),
            location_type: $("select[name=location_type]").val(),
            location_value: $("input[name=location_value]").val(),
            date_filter: $("select[name=date_filter]").val(),
            from_date: $("input[name=from_date]").val(),
            to_date: $("input[name=to_date]").val(),
        };

        // Remove empty values
        Object.keys(params).forEach((k) => !params[k] && delete params[k]);

        let finalUrl = baseUrl + "?" + $.param(params);

        showProcessModal(title, text, color);

        setTimeout(() => $("#downloadFrame").attr("src", finalUrl), 500);
        setTimeout(() => $("#fileProcessModal").modal("hide"), 2500);
    });
}

// Initialize
handleExport(
    ".export-excel",
    "Exporting Excel",
    "Preparing Excel file...",
    "#28a745",
);
handleExport(
    ".export-pdf",
    "Exporting PDF",
    "Preparing PDF file...",
    "#dc3545",
);
