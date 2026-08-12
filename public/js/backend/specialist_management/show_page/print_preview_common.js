$(function () {
    window.patientCardPrint = {
        themeContainers: [
            ".card-preview-container",
            ".card-preview-container2",
            ".card-preview-container3",
        ],
        getThemeContainer: function () {
            let theme = $("#card_theme").val() || "1";
            let container = $(
                this.themeContainers[parseInt(theme) - 1],
            ).first();
            if (!container.length)
                container = $(
                    ".card-preview-middle,.card-preview-container,.card-preview-container2,.card-preview-container3",
                )
                    .filter(":visible")
                    .first();
            return container;
        },
        getFront: function () {
            let container = this.getThemeContainer();
            if (!container.length) return $();
            let selectors = [".doctor-card", ".wide-card", ".doctor-card-3"];
            for (let selector of selectors) {
                let card = container.find(selector).first();
                if (card.length) return card;
            }
            return container
                .find("[class*='doctor-card'],[class*='wide-card']")
                .filter(function () {
                    return (
                        !$(this).hasClass("doctor-card-back") &&
                        !$(this).hasClass("doctor-card-back-3") &&
                        !$(this).hasClass("wide-card-back")
                    );
                })
                .first();
        },
        getBack: function () {
            let container = this.getThemeContainer();
            if (!container.length) return $();
            let selectors = [
                ".doctor-card-back",
                ".wide-card-back",
                ".doctor-card-back-3",
            ];
            for (let selector of selectors) {
                let card = container.find(selector).first();
                if (card.length) return card;
            }
            return $();
        },
        getCardType: function () {
            let front = this.getFront();
            if (!front.length) return "vertical";
            if (front.hasClass("wide-card")) return "wide";
            if (front.hasClass("doctor-card-3")) return "vertical";
            return "vertical";
        },
        getCopies: function () {
            return Math.max(1, parseInt($("#cardPrintCopies").val()) || 1);
        },
        clean: function (element) {
            let clone = element.clone(false);
            clone.removeAttr("id");
            clone
                .find(
                    ".print-card-actions,.whole-card-action-buttons,.lanyard-action-buttons,.whole-lanyard-action-buttons",
                )
                .remove();
            return clone;
        },
        clearGrid: function () {
            $("#printCardGrid").empty();
        },
        createItem: function (front, back, type, index) {
            let item = $("<div>", { class: "print-card-item" });
            let sides = $("<div>", { class: "print-card-sides" });
            if (front && front.length)
                sides.append(this.clean(front).addClass("print-front-side"));
            if (back && back.length)
                sides.append(this.clean(back).addClass("print-back-side"));
            item.attr("data-card-index", index);
            item.attr("data-card-type", type);
            item.append(sides);
            return item;
        },
        generate: function (mode) {
            let front = this.getFront();
            let back = this.getBack();
            let type = this.getCardType();
            let copies = this.getCopies();
            let grid = $("#printCardGrid");
            if (!grid.length) return;
            this.clearGrid();
            if (mode === "front") {
                for (let i = 0; i < copies; i++) {
                    let item = $("<div>", {
                        class: "print-card-item print-front-only",
                    });
                    item.append(this.clean(front).addClass("print-front-side"));
                    grid.append(item);
                }
            } else if (mode === "back") {
                for (let i = 0; i < copies; i++) {
                    let item = $("<div>", {
                        class: "print-card-item print-back-only",
                    });
                    item.append(this.clean(back).addClass("print-back-side"));
                    grid.append(item);
                }
            } else {
                for (let i = 0; i < copies; i++) {
                    grid.append(this.createItem(front, back, type, i));
                }
            }
            grid.attr("data-print-mode", mode);
            grid.attr("data-card-type", type);
            this.applyLayout(type, mode);
        },
        applyLayout: function (type, mode) {
            let grid = $("#printCardGrid");
            grid.removeClass(
                "print-layout-vertical print-layout-wide print-mode-front print-mode-back print-mode-whole",
            );
            grid.addClass(
                type === "wide" ? "print-layout-wide" : "print-layout-vertical",
            );
            grid.addClass("print-mode-" + mode);
        },
        open: function (mode) {
            window.patientCardPrint.mode = mode;
            $("#printPreviewModal").modal("show");
            this.generate(mode);
        },
    };
    $(document).on("change", "#cardPrintCopies", function () {
        if (window.patientCardPrint.mode)
            window.patientCardPrint.generate(window.patientCardPrint.mode);
    });
    $(document).on("change", "#card_theme", function () {
        if (window.patientCardPrint.mode)
            window.patientCardPrint.generate(window.patientCardPrint.mode);
    });
    $("#printPreviewModal").on("shown.bs.modal", function () {
        if (window.patientCardPrint.mode)
            window.patientCardPrint.generate(window.patientCardPrint.mode);
    });
    (function ($) {
        "use strict";

        $(document).on(
            "hidden.bs.modal.cardPrintCleanup",
            "#printPreviewModal",
            function () {
                $("#printCardGrid").empty();

                setTimeout(function () {
                    if (!$(".modal.show").length) {
                        $(".modal-backdrop").remove();

                        $("body").removeClass("modal-open").css({
                            paddingRight: "",
                            overflow: "",
                        });
                    }
                }, 100);
            },
        );
    })(jQuery);
});
