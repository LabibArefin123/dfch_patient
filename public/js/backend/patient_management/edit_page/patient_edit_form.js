document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
    initializeLocationToggle();
    initializeRecommendToggle();
    initializeTreatmentToggle();
    initializeInvestigationToggle();
});

/*
|--------------------------------------------------------------------------
| CKEditor
|--------------------------------------------------------------------------
*/

function initializeEditors() {
    const editors = [
        "#edit_remarks",
        "#edit_recommend_note",
        "#edit_patient_problem_description",
        "#edit_patient_drug_description",

        "#edit_treatment_information",
        "#edit_investigation_information",
    ];

    editors.forEach(function (selector) {
        const element = document.querySelector(selector);

        if (!element) {
            return;
        }

        ClassicEditor.create(element, {
            toolbar: [
                "heading",
                "|",
                "bold",
                "italic",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "undo",
                "redo",
            ],
        }).catch(function (error) {
            console.error(error);
        });
    });
}

/*
|--------------------------------------------------------------------------
| Location
|--------------------------------------------------------------------------
*/

function toggleLocation() {
    $(".location").hide();

    $(".location-" + $("#location_type").val()).show();
}

function initializeLocationToggle() {
    toggleLocation();

    $("#location_type").on("change", toggleLocation);
}

/*
|--------------------------------------------------------------------------
| Recommendation
|--------------------------------------------------------------------------
*/

function toggleRecommend() {
    if ($("#is_recommend").val() == "1") {
        $(".recommend-section").slideDown(250);
    } else {
        $(".recommend-section").slideUp(250);
    }
}

function initializeRecommendToggle() {
    toggleRecommend();

    $("#is_recommend").on("change", toggleRecommend);
}

/*
|--------------------------------------------------------------------------
| Treatment
|--------------------------------------------------------------------------
*/

function toggleTreatment() {
    if ($("#is_treatment").val() == "1") {
        $(".treatment-section").stop(true, true).slideDown(250);
    } else {
        $(".treatment-section").stop(true, true).slideUp(250);
    }
}

function initializeTreatmentToggle() {
    toggleTreatment();

    $("#is_treatment").on("change", toggleTreatment);
}

/*
|--------------------------------------------------------------------------
| Investigation
|--------------------------------------------------------------------------
*/

function toggleInvestigation() {
    if ($("#is_investigated").val() == "1") {
        $(".investigation-section").stop(true, true).slideDown(250);
    } else {
        $(".investigation-section").stop(true, true).slideUp(250);
    }
}

function initializeInvestigationToggle() {
    toggleInvestigation();

    $("#is_investigated").on("change", toggleInvestigation);
}
