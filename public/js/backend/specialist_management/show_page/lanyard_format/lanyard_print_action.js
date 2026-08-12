$(function () {
    function addLanyardPrintButtons() {
        $(
            ".lanyard-preview-container,.lanyard-preview-container2,.lanyard-preview-container3",
        ).each(function () {
            $(this)
                .find(".lanyard-strip,.lanyard02-strip,.lanyard03-strip")
                .each(function (index) {
                    const strip = $(this);
                    if (strip.find(".lanyard-action-buttons").length) return;
                    const buttons = $("<div>", {
                        class: "lanyard-action-buttons",
                    });
                    buttons.append(
                        $("<button>", {
                            type: "button",
                            class: "btn btn-sm btn-danger lanyard-print-btn",
                            "data-lanyard-index": index,
                        }).html('<i class="fas fa-print"></i> Print'),
                    );
                    strip.css("position", "relative").append(buttons);
                });
        });
    }
    function printLanyard(element) {
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
            "<!DOCTYPE html><html><head><title>Print Lanyard</title>" +
                styles +
                "<style>@page{margin:10mm}body{margin:0;display:flex;justify-content:center;align-items:center;min-height:100vh}.lanyard-strip,.lanyard02-strip,.lanyard03-strip{margin:0!important}</style></head><body>" +
                clone.outerHTML +
                "</body></html>",
        );
        win.document.close();
        win.focus();
        setTimeout(function () {
            win.print();
            win.close();
        }, 700);
    }
    $(document).on("click", ".lanyard-print-btn", function () {
        printLanyard(
            $(this).closest(
                ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
            )[0],
        );
    });
    addLanyardPrintButtons();
});
