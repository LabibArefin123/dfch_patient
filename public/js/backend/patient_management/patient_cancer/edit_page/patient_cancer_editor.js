document.addEventListener("DOMContentLoaded", function () {
    initializeCancerEditors();
});

/* --------------------------------------------------------------------------
| Initialize Cancer Editors
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
        console.warn("Cancer editor textarea not found:", selector);

        return;
    }

    if (textarea.dataset.editorInitialized === "true") {
        return;
    }

    if (typeof ClassicEditor === "undefined") {
        console.error("ClassicEditor is not loaded.");

        return;
    }

    ClassicEditor.create(textarea)

        .then(function (editor) {
            textarea.editor = editor;

            textarea.dataset.editorInitialized = "true";

            console.log("Cancer editor initialized:", selector);
        })

        .catch(function (error) {
            console.error("CKEditor initialization failed:", selector, error);
        });
}

/* --------------------------------------------------------------------------
| Refresh
--------------------------------------------------------------------------- */

window.refreshCancerEditors = function () {
    initializeCancerEditors();
};
