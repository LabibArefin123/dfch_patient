document.addEventListener("DOMContentLoaded", function () {
    initializeSpecialistCard();

    $("#card_theme").on("change", function () {
        initializeSpecialistCard();
    });
});

function initializeSpecialistCard() {
    $(".card-preview-container").hide();
    $(".card-preview-container2").hide();

    let theme = $("#card_theme").val() || "1";

    switch (theme) {
        case "1":
            $(".card-preview-container").show();
            break;

        case "2":
            $(".card-preview-container2").show();
            break;

        default:
            $(".card-preview-container").show();
    }
}
