document.addEventListener("DOMContentLoaded", () => {
    initializeCancerEditors();
});

/* --------------------------------------------------------------------------
| Initialize All Editors
---------------------------------------------------------------------------*/

function initializeCancerEditors() {
    initializeEditor("#cancer_remarks");

    initializeDescriptionEditors();
}

/* --------------------------------------------------------------------------
| Generic Editor
---------------------------------------------------------------------------*/

function initializeEditor(selector) {
    const textarea = document.querySelector(selector);

    if (!textarea) return;

    if (textarea.dataset.editorInitialized) return;

    ClassicEditor.create(textarea)
        .then((editor) => {
            textarea.editor = editor;

            textarea.dataset.editorInitialized = "true";
        })
        .catch(console.error);
}

/* --------------------------------------------------------------------------
| Description Editors
---------------------------------------------------------------------------*/

function initializeDescriptionEditors() {
    document
        .querySelectorAll(".xray-description-editor")
        .forEach((textarea) => {
            if (textarea.dataset.editorInitialized) {
                return;
            }

            ClassicEditor.create(textarea)
                .then((editor) => {
                    textarea.editor = editor;

                    textarea.dataset.editorInitialized = "true";
                })
                .catch(console.error);
        });
}

/* --------------------------------------------------------------------------
| Refresh
---------------------------------------------------------------------------*/

window.refreshCancerEditors = function () {
    initializeDescriptionEditors();
};
