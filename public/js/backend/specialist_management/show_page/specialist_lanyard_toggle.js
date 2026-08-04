document.addEventListener("DOMContentLoaded", function () {
    initializeSpecialistLanyard();

    $("#lanyard_theme").on("change", function () {
        initializeSpecialistLanyard();
    });
});

function initializeSpecialistLanyard() {
    $(".lanyard-preview-container").hide();
    $(".lanyard-preview-container2").hide();
    $(".lanyard-preview-container3").hide();

    let theme = $("#lanyard_theme").val() || "1";

    switch (theme) {
        case "1":
            $(".lanyard-preview-container").show();
            break;

        case "2":
            $(".lanyard-preview-container2").show();
            break;

        case "3":
            $(".lanyard-preview-container3").show();
            break;

        default:
            $(".lanyard-preview-container").show();
    }
}
