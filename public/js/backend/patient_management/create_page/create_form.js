document.addEventListener("DOMContentLoaded", function () {
    initializeLocationToggle();
    initializeRecommendToggle();
    initializeTreatmentToggle();
    initializeInvestigationToggle();
});

/* --------------------------------------------------------------------------
 | Location
 * -------------------------------------------------------------------------- */

function toggleLocation() {
    $(".location").addClass("d-none");
    $(".location-" + $("#location_type").val()).removeClass("d-none");
}

function initializeLocationToggle() {
    toggleLocation();

    $("#location_type").on("change", function () {
        toggleLocation();
    });
}

/* --------------------------------------------------------------------------
 | Recommendation
 * -------------------------------------------------------------------------- */

function toggleRecommend() {
    if ($("#is_recommend").val() == "1") {
        $(".recommend-section").removeClass("d-none");
    } else {
        $(".recommend-section").addClass("d-none");
    }
}

function initializeRecommendToggle() {
    toggleRecommend();

    $("#is_recommend").on("change", function () {
        toggleRecommend();
    });
}

/* --------------------------------------------------------------------------
 | Treatment
 * -------------------------------------------------------------------------- */

function toggleTreatment() {
    if ($("#is_treatment").val() == "1") {
        $("#treatmentSection").stop(true, true).slideDown(300);
    } else {
        $("#treatmentSection").stop(true, true).slideUp(300);
    }
}

function initializeTreatmentToggle() {
    toggleTreatment();

    $("#is_treatment").on("change", function () {
        toggleTreatment();
    });
}

/* --------------------------------------------------------------------------
 | Investigation
 * -------------------------------------------------------------------------- */

function toggleInvestigation() {
    if ($("#is_investigated").val() == "1") {
        $("#investigationSection").stop(true, true).slideDown(300);
    } else {
        $("#investigationSection").stop(true, true).slideUp(300);
    }
}

function initializeInvestigationToggle() {
    toggleInvestigation();

    $("#is_investigated").on("change", function () {
        toggleInvestigation();
    });
}
