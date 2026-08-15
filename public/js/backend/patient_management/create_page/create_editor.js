document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
});

function initializeEditors() {
    const editors = [
        // Patient
        "#patient_problem_description",
        "#patient_drug_description",
        "#remarks",
        // Refer Part
        "#referred_note",
        // Emergency Part
        "#emergency_details",
        // Treatment Part
        "#treatment_information",
        // Investigation Part
        "#investigation_information",
        // Cancer Part
        "#xray_description",
        "#cancer_remarks",
    ];

    editors.forEach(function (selector) {
        const element = document.querySelector(selector);

        if (!element) {
            return;
        }

        ClassicEditor.create(element)
            .then((editor) => {
                element.ckeditorInstance = editor;
            })
            .catch((error) => {
                console.error(error);
            });
    });
}
