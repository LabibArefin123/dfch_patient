document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
});

function initializeEditors() {
    const editors = [
        "#patient_problem_description",
        "#patient_drug_description",
    ];

    editors.forEach(function (selector) {
        const element = document.querySelector(selector);

        if (!element) {
            return;
        }

        ClassicEditor.create(element).catch(function (error) {
            console.error(error);
        });
    });
}
