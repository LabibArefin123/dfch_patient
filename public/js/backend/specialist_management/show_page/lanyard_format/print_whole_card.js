$(function () {
    function getSelectedLanyard() {
        const selected = window.selectedLanyard;

        if (selected && selected.length) {
            return selected.first();
        }

        const active = $(".lanyard-card.active").first();

        if (active.length) {
            return active;
        }

        const first = $(".lanyard-card").first();

        if (first.length) {
            return first;
        }

        return null;
    }

    function printWholeLanyard() {
        const lanyard = getSelectedLanyard();

        if (!lanyard) {
            alert("Please select a lanyard first.");
            return;
        }

        const clone = lanyard.clone();

        clone
            .find(
                ".lanyard-action-buttons,.whole-lanyard-action-buttons,.whole-card-action-buttons",
            )
            .remove();

        const wrapper = $("<div>", {
            class: "print-whole-lanyard-wrapper",
        });

        wrapper.append(clone);

        const win = window.open("", "_blank", "width=900,height=1000");

        if (!win) {
            alert("Please allow pop-ups for this website.");
            return;
        }

        const styles = [
            ...document.querySelectorAll("link[rel='stylesheet'],style"),
        ]
            .map(function (el) {
                return el.outerHTML;
            })
            .join("");

        win.document.write(`
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Print Whole Lanyard</title>
${styles}
<style>
@page{
size:auto;
margin:10mm;
}

html,body{
margin:0;
padding:0;
background:#fff;
}

body{
display:flex;
justify-content:center;
align-items:flex-start;
min-height:100vh;
}

.print-whole-lanyard-wrapper{
display:flex;
justify-content:center;
align-items:flex-start;
width:max-content;
}

.print-whole-lanyard-wrapper .lanyard-card{
width:170px!important;
margin:0!important;
box-shadow:none!important;
border:2px solid #ddd!important;
overflow:hidden!important;
}

.print-whole-lanyard-wrapper .lanyard-title{
display:block!important;
}

.print-whole-lanyard-wrapper .lanyard-body,
.print-whole-lanyard-wrapper .lanyard02-body,
.print-whole-lanyard-wrapper .lanyard03-body{
height:300px!important;
}

.print-whole-lanyard-wrapper .lanyard-strip,
.print-whole-lanyard-wrapper .lanyard02-strip,
.print-whole-lanyard-wrapper .lanyard03-strip{
margin-top:0!important;
}

.print-whole-lanyard-wrapper .lanyard-strip + .lanyard-strip,
.print-whole-lanyard-wrapper .lanyard02-strip + .lanyard02-strip,
.print-whole-lanyard-wrapper .lanyard03-strip + .lanyard03-strip{
margin-top:16px!important;
}

.lanyard-action-buttons,
.whole-lanyard-action-buttons,
.whole-card-action-buttons{
display:none!important;
}

*{
print-color-adjust:exact!important;
-webkit-print-color-adjust:exact!important;
}
</style>
</head>
<body>
${wrapper.prop("outerHTML")}
</body>
</html>
`);

        win.document.close();

        const waitForImages = function () {
            const images = win.document.images;

            if (!images.length) {
                startPrint();
                return;
            }

            let loaded = 0;

            function done() {
                loaded++;

                if (loaded >= images.length) {
                    startPrint();
                }
            }

            for (let i = 0; i < images.length; i++) {
                if (images[i].complete) {
                    done();
                } else {
                    images[i].addEventListener("load", done);
                    images[i].addEventListener("error", done);
                }
            }
        };

        function startPrint() {
            setTimeout(function () {
                win.focus();
                win.print();

                setTimeout(function () {
                    win.close();
                }, 500);
            }, 500);
        }

        setTimeout(waitForImages, 300);
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
