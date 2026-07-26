document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
});

function initializeEditors() {
    const editors = [
        "#patient_problem_description",
        "#patient_drug_description",

        // Treatment
        "#treatment_information",

        // Investigation
        "#investigation_information",
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
