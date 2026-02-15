let progressInterval = null;
let circle = null;
let radius = 52;
let circumference = 2 * Math.PI * radius;

function showProcessModal(title, text, color = "#28a745") {
    $("#processTitle").text(title);
    $("#processText").text(text);
    circle = document.getElementById("progressCircle");
    if (!circle) return;

    if (progressInterval) clearInterval(progressInterval);
    progressInterval = null;

    $("#progressPercent").text("0%");
    circle.style.stroke = color;
    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    $("#fileProcessModal").modal({ backdrop: "static", keyboard: false });
    animateProgress();
}

function animateProgress() {
    let percent = 0;
    progressInterval = setInterval(() => {
        percent = Math.min(percent + 2, 100);
        circle.style.strokeDashoffset =
            circumference - (percent / 100) * circumference;
        $("#progressPercent").text(percent + "%");

        if (percent >= 100) {
            clearInterval(progressInterval);
            progressInterval = null;
            setTimeout(() => $("#fileProcessModal").modal("hide"), 400);
        }
    }, 40);
}

$(function () {
    // URL Filter Auto Fill
    const urlParams = new URLSearchParams(window.location.search);
    const presetFilters = [
        "gender",
        "is_recommend",
        "location_type",
        "location_value",
        "date_filter",
        "from_date",
        "to_date",
    ];
    presetFilters.forEach((key) => {
        const val = urlParams.get(key);
        if (val !== null) $(`[name="${key}"]`).val(val);
    });
    if ($("select[name=date_filter]").val() === "custom")
        $("#startDateDiv, #endDateDiv").removeClass("d-none");

    // Fix No Filter Modal
    $(document).on(
        "click",
        "#noFilterModal .close, #noFilterModal .btn-danger",
        () => $("#noFilterModal").modal("hide"),
    );
    $("#noFilterModal").on("hidden.bs.modal", () => {
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
    });
});
