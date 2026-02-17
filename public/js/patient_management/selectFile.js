$(document).ready(function () {
    let lastChecked = null;

    // SHIFT SELECT
    $(document).on("click", ".row-checkbox", function (e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            let checkboxes = $(".row-checkbox");
            let start = checkboxes.index(this);
            let end = checkboxes.index(lastChecked);

            checkboxes
                .slice(Math.min(start, end), Math.max(start, end) + 1)
                .prop("checked", lastChecked.checked);
        }

        lastChecked = this;
        updateSelectAll();
    });

    // SELECT ALL
    $(document).on("click", "#select-all", function () {
        $(".row-checkbox").prop("checked", $(this).prop("checked"));
    });

    function updateSelectAll() {
        const total = $(".row-checkbox").length;
        const checked = $(".row-checkbox:checked").length;
        $("#select-all").prop("checked", total === checked);
    }

    // OPEN MODAL
    $("#delete-selected").on("click", function () {
        const ids = getSelectedIds();

        if (ids.length === 0) {
            $("#noFilterModal").modal("show");
            return;
        }

        $("#selectedCount").text(ids.length);
        $("#selectPatientsModal").modal("show");
    });

    // CONFIRM DELETE
    $("#confirmDeleteSelected").on("click", function () {
        const ids = getSelectedIds();

        if (ids.length === 0) return;

        $("#selectPatientsModal").modal("hide");
        $("#fileProcessModal").modal("show");

        $("#processTitle").text("Deleting Patients...");
        $("#processText").text(
            "Please wait while we delete selected patients.",
        );
        updateProgress(30);

        $.ajax({
            url: "/patients/delete-selected",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                ids: ids,
            },
            success: function (response) {
                updateProgress(100);

                setTimeout(function () {
                    $("#fileProcessModal").modal("hide");
                    $("#patientsTable").DataTable().ajax.reload(null, false);
                }, 800);
            },
            error: function () {
                alert("Something went wrong.");
                $("#fileProcessModal").modal("hide");
            },
        });
    });

    function getSelectedIds() {
        return $(".row-checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
    }

    function updateProgress(percent) {
        const circle = document.getElementById("progressCircle");
        const percentText = document.getElementById("progressPercent");
        const radius = 65;
        const circumference = 2 * Math.PI * radius;

        const offset = circumference - (percent / 100) * circumference;
        circle.style.strokeDashoffset = offset;
        percentText.innerText = percent + "%";
    }
});
