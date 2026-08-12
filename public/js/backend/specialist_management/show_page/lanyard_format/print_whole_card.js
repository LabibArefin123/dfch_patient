$(function () {
    function getSelectedLanyard() {
        const selected = window.selectedLanyard;
        if (selected && selected.length) return selected.first();
        const active = $(".lanyard-card.active").first();
        if (active.length) return active;
        const first = $(".lanyard-card").first();
        if (first.length) return first;
        return null;
    }
    function getLanyardClone() {
        const lanyard = getSelectedLanyard();
        if (!lanyard || !lanyard.length) return null;
        const clone = lanyard.clone();
        clone
            .find(
                ".whole-lanyard-action-buttons,.whole-card-action-buttons,.lanyard-action-buttons",
            )
            .remove();
        return clone;
    }
    function printWholeLanyard() {
        const lanyard = getLanyardClone();
        if (!lanyard) {
            alert("Please select a lanyard first.");
            return;
        }
        const win = window.open("", "_blank", "width=900,height=900");
        if (!win) {
            alert("Please allow pop-ups for this website.");
            return;
        }
        const styles = [
            ...document.querySelectorAll("link[rel='stylesheet'],style"),
        ]
            .map((el) => el.outerHTML)
            .join("");
        win.document.write(
            "<!DOCTYPE html><html><head><title>Print Lanyard</title>" +
                styles +
                "<style>@page{size:auto;margin:0}body{margin:0;padding:25px;display:flex;justify-content:center;align-items:flex-start;background:#fff}.lanyard-card{margin:0!important;overflow:visible!important}.lanyard-action-buttons,.whole-lanyard-action-buttons,.whole-card-action-buttons{display:none!important}</style></head><body>" +
                lanyard.prop("outerHTML") +
                "</body></html>",
        );
        win.document.close();
        win.focus();
        setTimeout(function () {
            win.print();
            win.close();
        }, 700);
    }
    $(document).on(
        "click",
        ".whole-lanyard-print-btn,.whole-card-print-btn",
        function (e) {
            e.preventDefault();
            printWholeLanyard();
        },
    );
});
