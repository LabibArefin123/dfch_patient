function toggleSelectedButtons() {
    if (selectedRows.length > 0) {
        $("#downloadSelectedPdf").removeClass("d-none");
        $("#downloadSelectedExcel").removeClass("d-none");
    } else {
        $("#downloadSelectedPdf").addClass("d-none");
        $("#downloadSelectedExcel").addClass("d-none");
    }
}

$("#downloadSelectedPdf").on("click", function (e) {
    e.preventDefault();

    if (selectedRows.length === 0) {
        alert("Please select rows");
        return;
    }

    let params = new URLSearchParams($("#filterForm").serialize());

    selectedRows.forEach(function (id) {
        params.append("ids[]", id);
    });

    window.open(reportPdfRoute + "?" + params.toString(), "_blank");
});

$("#downloadSelectedExcel").on("click", function (e) {
    e.preventDefault();

    if (selectedRows.length === 0) {
        alert("Please select rows");
        return;
    }

    let params = new URLSearchParams($("#filterForm").serialize());

    selectedRows.forEach(function (id) {
        params.append("ids[]", id);
    });

    window.location.href = reportExcelRoute + "?" + params.toString();
});
