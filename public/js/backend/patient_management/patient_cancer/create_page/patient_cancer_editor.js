document.addEventListener("DOMContentLoaded", () => {
    initializeCancerEditors();
});

/* --------------------------------------------------------------------------
| Initialize All Editors
--------------------------------------------------------------------------- */

function initializeCancerEditors() {
    initializeEditor("#cancer_remarks");
    initializeEditor("#xray_description");
}

/* --------------------------------------------------------------------------
| Generic CKEditor Initializer
--------------------------------------------------------------------------- */

function initializeEditor(selector) {
    const textarea = document.querySelector(selector);

    if (!textarea) {
        return;
    }

    if (textarea.dataset.editorInitialized) {
        return;
    }

    ClassicEditor.create(textarea)
        .then((editor) => {
            textarea.editor = editor;
            textarea.dataset.editorInitialized = "true";
        })
        .catch((error) => {
            console.error("CKEditor initialization failed:", error);
        });
}

/* --------------------------------------------------------------------------
| Refresh (Optional)
--------------------------------------------------------------------------- */

window.refreshCancerEditors = function () {
    initializeCancerEditors();
};
