function patientSummarySearch() {
    let keyword = $("#patientSummarySearch").val().trim();

    if (keyword == "") return;

    $("#patientTyping").removeClass("d-none");

    $.ajax({
        url: patientSummarySearchUrl,
        type: "POST",

        data: {
            search: keyword,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (res) {
            $("#patientTyping").addClass("d-none");

            if (!res.status) {
                appendBotMessage(
                    "❌ Patient not found in this chat.<br><br>Search another patient?",
                );

                $("#patientSummaryAction").removeClass("d-none");

                $("#patientSearchResult").html("");

                $("#patientSummaryDetail").html("");

                return;
            }

            appendBotMessage("✅ Found " + res.count + " patient(s).");

            let html = "";

            $.each(res.patients, function (i, p) {
                html += `
<div class="card mb-2 shadow-sm">

<div class="card-body p-2">

<div class="d-flex justify-content-between align-items-center">

<div>

<strong>${p.patient_name}</strong><br>

<small>${p.patient_code}</small>

</div>

<button
class="btn btn-primary btn-sm patient-summary-show"
data-patient='${JSON.stringify(p)}'>

Show

</button>

</div>

</div>

</div>
`;
            });

            $("#patientSearchResult").html(html);
        },

        error: function () {
            $("#patientTyping").addClass("d-none");

            appendBotMessage("Something went wrong.");
        },
    });
}

$(document).on("click", ".patient-summary-show", function () {
    let p = $(this).data("patient");

    let html = `

<div class="row">

<div class="col-md-4 text-center">

<img src="${p.patient_photo}" class="img-fluid rounded border" style="height:260px;width:100%;object-fit:contain">

</div>

<div class="col-md-8">

<table class="table table-sm table-bordered">

<tr><th>Name</th><td>${p.patient_name}</td></tr>

<tr><th>Code</th><td>${p.patient_code}</td></tr>

<tr><th>Age</th><td>${p.age}</td></tr>

<tr><th>Gender</th><td>${p.gender}</td></tr>

<tr><th>Phone</th><td>${p.phone}</td></tr>

<tr><th>Father</th><td>${p.father}</td></tr>

<tr><th>Mother</th><td>${p.mother}</td></tr>

<tr><th>Problem</th><td>${p.problem ?? "N/A"}</td></tr>

<tr><th>Drug</th><td>${p.drug ?? "N/A"}</td></tr>

<tr><th>Documents</th><td>${p.documents}</td></tr>

<tr><th>Cancer Reports</th><td>${p.cancer_reports}</td></tr>

<tr><th>Date</th><td>${p.date}</td></tr>

<tr><th>Remarks</th><td>${p.remarks ?? "N/A"}</td></tr>

</table>

</div>

</div>

`;

    $("#patientSummaryDetail").html(html);

    appendBotMessage(
        "📄 Showing details for <strong>" + p.patient_name + "</strong>.",
    );
});
