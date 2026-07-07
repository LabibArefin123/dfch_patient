$(document).on("click", ".header-link", function () {
    let phone = $(this).data("phone");

    if (!phone || phone === "N/A") {
        return;
    }

    phone = phone.toString().replace(/[^0-9]/g, "");

    $("#selectedPhone").text(phone);
    $("#confirmWhatsapp").attr("href", "https://wa.me/" + phone);

    $("#callConfirmModal").modal("show");
    $("#cancelCall").on("click", function () {
        $("#callConfirmModal").modal("hide");
    });
});
