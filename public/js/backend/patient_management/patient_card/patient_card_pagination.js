$(document).on("click", "#patientCardPagination a", function (e) {
    e.preventDefault();

    const page = new URL($(this).attr("href")).searchParams.get("page");

    loadPatientCards(page, window.patientCard.search);

    $("html, body").animate(
        {
            scrollTop: $(".patient-card-container").offset().top - 80,
        },
        250,
    );
});
