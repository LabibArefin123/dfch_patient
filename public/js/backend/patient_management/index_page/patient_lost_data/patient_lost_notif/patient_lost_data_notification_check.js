/*
|--------------------------------------------------------------------------
| PATIENT LOST DATA - CHECK PENDING DRAFTS
|--------------------------------------------------------------------------
|
| Draft notification is only checked when:
|
| /patients?check_draft=1
|
| This allows the notification to appear specifically after the user
| clicks "Back to Patients" from the Patient Create page.
|
|--------------------------------------------------------------------------
*/

function shouldCheckPatientDraft() {

    const params = new URLSearchParams(
        window.location.search
    );

    return params.get("check_draft") === "1";
}


/*
|--------------------------------------------------------------------------
| Remove check_draft from URL
|--------------------------------------------------------------------------
|
| After checking, remove the query parameter so refreshing the page
| does not repeatedly trigger the draft check.
|
|--------------------------------------------------------------------------
*/

function removePatientDraftCheckParameter() {

    const url = new URL(
        window.location.href
    );

    url.searchParams.delete("check_draft");

    window.history.replaceState(
        {},
        document.title,
        url.pathname +
        (url.searchParams.toString()
            ? "?" + url.searchParams.toString()
            : "") +
        url.hash
    );
}


/*
|--------------------------------------------------------------------------
| CHECK PENDING PATIENT DRAFTS
|--------------------------------------------------------------------------
*/

function checkPendingPatientDrafts() {

    /*
    |--------------------------------------------------------------------------
    | Only check when explicitly requested
    |--------------------------------------------------------------------------
    */

    if (!shouldCheckPatientDraft()) {
        return;
    }

    const url =
        window.patientRoutes?.lostDataPending ||
        "/patient-drafts/pending";


    $.ajax({

        url: url,

        method: "GET",

        dataType: "json",

        success: function (response) {

            /*
            |--------------------------------------------------------------------------
            | Remove the URL flag after the request succeeds
            |--------------------------------------------------------------------------
            */

            removePatientDraftCheckParameter();


            /*
            |--------------------------------------------------------------------------
            | No pending drafts
            |--------------------------------------------------------------------------
            */

            if (
                !response ||
                !response.success ||
                !response.count ||
                !response.drafts ||
                !response.drafts.length
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Get latest draft
            |--------------------------------------------------------------------------
            */

            const draft = response.drafts[0];


            /*
            |--------------------------------------------------------------------------
            | Show right-side notification
            |--------------------------------------------------------------------------
            */

            showLostPatientDataNotification(
                response.count,
                draft
            );
        },

        error: function (xhr) {

            console.warn(
                "Unable to check patient lost data.",
                xhr
            );
        }

    });
}

