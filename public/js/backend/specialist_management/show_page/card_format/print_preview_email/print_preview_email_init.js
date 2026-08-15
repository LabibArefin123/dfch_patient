(function (window, $) {
    "use strict";

    window.specialistCardEmail = window.specialistCardEmail || {};

    const Email = window.specialistCardEmail;

    Email.cleanupModal = function () {
        const $modal = $("#printPreviewEmailModal");

        if ($modal.length) {
            $modal.modal("hide");
        }

        setTimeout(function () {
            $(".modal-backdrop").remove();

            if (!$(".modal.show").length) {
                $("body").removeClass("modal-open").css({
                    paddingRight: "",
                    overflow: "",
                });
            }
        }, 100);
    };

    Email.removeBackdrop = function () {
        $(".modal-backdrop").remove();

        if (!$(".modal.show").length) {
            $("body").removeClass("modal-open").css({
                paddingRight: "",
                overflow: "",
            });
        }
    };

    $(document).on(
        "hidden.bs.modal.emailPrintCleanup",
        "#printPreviewEmailModal",
        function () {
            setTimeout(function () {
                Email.removeBackdrop();
            }, 50);
        },
    );

    $(window).on("afterprint", function () {
        setTimeout(function () {
            Email.removeBackdrop();
        }, 50);
    });
})(window, jQuery);
