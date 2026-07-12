(function () {
    $(document).on("click", ".recommendation-preview-image", function () {
        $("#imageZoomModal img").attr("src", $(this).data("image"));
    });
})();
