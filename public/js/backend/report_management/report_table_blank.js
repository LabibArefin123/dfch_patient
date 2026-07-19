$(function () {
    let table = $("#reportTable").DataTable({
        processing: true,
        serverSide: true,

        ajax: {
            url: reportTableRoute,

            dataSrc: function (json) {
                /*
                |--------------------------------------------------------------------------
                | No Data Available Today
                |--------------------------------------------------------------------------
                */

                if (
                    json.today_total !== undefined &&
                    Number(json.today_total) === 0
                ) {
                    $("#reportBlankModal").modal("show");
                }

                return json.data;
            },
        },
    });
});
