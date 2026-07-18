$(function () {
    $("#meetingViewToggle").on("click", function () {
        let btn = $(this);

        let mode = btn.data("view");

        if (mode === "date") {
            $(".date-wise-col").addClass("d-none");
            $(".summary-col").removeClass("d-none");

            btn.data("view", "summary");
            btn.html('<i class="fas fa-table mr-1"></i> Date Wise');
        } else {
            $(".summary-col").addClass("d-none");
            $(".date-wise-col").removeClass("d-none");

            btn.data("view", "date");
            btn.html(
                '<i class="fas fa-exchange-alt mr-1"></i> Summarized Table',
            );
        }
    });

    $(document).on("click", ".summary-dot", function () {
        let page = $(this).data("page");

        let wrapper = $(this).closest(".summary-col");

        wrapper.find(".summary-page").removeClass("active");

        wrapper.find(".summary-page").eq(page).addClass("active");
    });
});
    