/**
 * --------------------------------------------------------------------------
 * CKEditor
 * --------------------------------------------------------------------------
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
