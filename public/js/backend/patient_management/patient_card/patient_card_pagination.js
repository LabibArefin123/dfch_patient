$(document).on("click", "#patientCardPagination a", function (event) {
    event.preventDefault();

    const url = new URL($(this).attr("href"));

    const page = url.searchParams.get("page");

    const search = $("#patientCardSearch").val();

    loadPatientCards(page, search);

    $("html, body").animate(
        {
            scrollTop: $("#patientCardGrid").offset().top - 100,
        },
        300,
    );
});
