document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
    initializeLocationToggle();
    initializeRecommendToggle();
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
        }).catch((error) => console.error(error));
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
    if ($("#is_recommend").val() == 1) {
        $(".recommend-section").show();
    } else {
        $(".recommend-section").hide();
    }
}

function initializeRecommendToggle() {
    toggleRecommend();
    $("#is_recommend").on("change", toggleRecommend);
}
