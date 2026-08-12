$(function () {
    function addPreviewButtons() {
        $(
            ".lanyard-preview-container,.lanyard-preview-container2,.lanyard-preview-container3",
        )
            .find(".lanyard-strip,.lanyard02-strip,.lanyard03-strip")
            .each(function () {
                const strip = $(this);
                const buttons = strip.find(".lanyard-action-buttons");
                if (!buttons.length) return;
                if (buttons.find(".lanyard-preview-btn").length) return;
                buttons.append(
                    $("<button>", {
                        type: "button",
                        class: "btn btn-sm btn-info lanyard-preview-btn",
                    }).html('<i class="fas fa-eye"></i> Preview'),
                );
            });
    }
    function previewLanyard(element) {
        if (!element) return;
        const clone = element.cloneNode(true);
        $(clone).find(".lanyard-action-buttons").remove();
        const win = window.open("", "_blank", "width=900,height=900");
        if (!win) return;
        const styles = [
            ...document.querySelectorAll("link[rel='stylesheet'],style"),
        ]
            .map((el) => el.outerHTML)
            .join("");
        win.document.write(
            "<!DOCTYPE html><html><head><title>Lanyard Preview</title>" +
                styles +
                "<style>body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f5f5f5}.lanyard-strip,.lanyard02-strip,.lanyard03-strip{margin:0!important}</style></head><body>" +
                clone.outerHTML +
                "</body></html>",
        );
        win.document.close();
    }
    $(document).on("click", ".lanyard-preview-btn", function () {
        previewLanyard(
            $(this).closest(
                ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
            )[0],
        );
    });
    addPreviewButtons();
});
