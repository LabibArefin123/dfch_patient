/**
 * --------------------------------------------------------------------------
 * CKEditor
 * --------------------------------------------------------------------------
 */

function initializeEditors() {
    const editors = [
        // Basic Information
        "#edit_patient_problem_description",
        "#edit_patient_drug_description",

        // Recommendation
        "#edit_recommend_note",

        // Emergency
        "#edit_emergency_details",

        // Treatment
        "#edit_treatment_information",

        // Investigation
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
                "underline",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "link",
                "blockQuote",
                "|",
                "undo",
                "redo",
            ],
        })
            .then(function (editor) {
                // Store editor instance for later use
                element.ckeditorInstance = editor;
            })
            .catch(function (error) {
                console.error(error);
            });
    });
}
