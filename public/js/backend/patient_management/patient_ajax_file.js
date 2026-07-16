// Store selected patient IDs globally
window.selectedPatients = [];
$(function () {
    var table = $("#patientsTable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: window.patientRoutes.emergency,
            data: function (d) {
                d.gender = $("select[name=gender]").val();
                d.is_recommend = $("select[name=is_recommend]").val();
                d.location_type = $("select[name=location_type]").val();
                d.location_value = $("input[name=location_value]").val();
                d.date_filter = $("select[name=date_filter]").val();
                d.from_date = $("input[name=from_date]").val();
                d.to_date = $("input[name=to_date]").val();

                // NEW
                d.is_old_cancer = $("select[name=is_old_cancer]").val();
            },
            dataSrc: function (json) {
                $("#childCount").text(json.childPatients ?? 0);
                $("#adultCount").text(json.adultPatients ?? 0);
                $("#seniorCount").text(json.seniorPatients ?? 0);
                return json.data;
            },
        },
        columns: [
            {
                data: "checkbox",
                name: "checkbox",
                orderable: false,
                searchable: false,
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            {
                data: "photo",
                name: "photo",
                orderable: false,
                searchable: false,
            },

            // NEW
            {
                data: "emergency",
                name: "is_emergency",
                orderable: false,
                searchable: false,
            },

            { data: "patient_code", name: "patient_code" },
            { data: "name", name: "patient_name" },
            { data: "age", name: "age" },
            { data: "gender", name: "gender" },
            { data: "phone", name: "phone_1" },

            {
                data: "location",
                name: "location",
                orderable: false,
                searchable: false,
            },

            { data: "is_recommend", name: "is_recommend" },

            {
                data: "does_old_cancer",
                name: "is_old_cancer",
                orderable: false,
                searchable: false,
            },

            {
                data: "total_cancer_photos",
                name: "total_cancer_photos",
                orderable: false,
                searchable: false,
            },

            { data: "date", name: "date_of_patient_added" },

            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    // ===============================
    // Selected Patients
    // ===============================

    function updateSelectedPatients() {
        window.selectedPatients = [];

        let html = "";

        $(".row-checkbox:checked").each(function () {
            let id = $(this).val();

            let row = $(this).closest("tr");

            let code = row.find("td:eq(4)").text().trim();
            let name = row.find("td:eq(5)").text().trim();

            window.selectedPatients.push(id);

            html += `
            <div class="d-flex justify-content-between align-items-center border-bottom py-1">

                <div>
                    <strong>${code}</strong><br>
                    <small class="text-muted">${name}</small>
                </div>

                <i class="fas fa-check-circle text-success"></i>

            </div>
        `;
        });

        $("#selectedPatients").val(window.selectedPatients.join(","));

        $("#selectedPatientCount").text(window.selectedPatients.length);

        $("#selectedPatientBadge").text(
            window.selectedPatients.length + " Selected",
        );

        if (window.selectedPatients.length === 0) {
            html = `
            <div class="text-center text-muted py-2">
                No patients selected.
            </div>
        `;
        }

        $("#selectedPatientList").html(html);
    }

    // Individual checkbox
    $(document).on("change", ".row-checkbox", function () {
        updateSelectedPatients();
    });

    // Select All
    $(document).on("change", "#checkAll", function () {
        $(".row-checkbox").prop("checked", $(this).is(":checked"));

        updateSelectedPatients();
    });

    // Open Emergency Modal
    $(document).on("click", "#btnEmergency", function () {
        updateSelectedPatients();

        if (window.selectedPatients.length === 0) {
            toastr.warning("Please select at least one patient.");
            return;
        }

        var modal = new bootstrap.Modal(
            document.getElementById("patientEmergencyModal"),
        );
        modal.show();
    });

    // After every DataTable redraw
    table.on("draw", function () {
        updateSelectedPatients();
    });

    // Filter submit
    $("#patientFilterForm").on("submit", function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
