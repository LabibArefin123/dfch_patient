(function (window, $) {
    "use strict";

    const Email = (window.specialistCardEmail =
        window.specialistCardEmail || {});

    Email.addModal = function () {
        if ($("#printPreviewEmailModal").length) {
            return;
        }

        const modal = `
            <div
                class="modal fade"
                id="printPreviewEmailModal"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header bg-danger text-white">

                            <h5 class="modal-title">
                                <i class="fas fa-envelope mr-2"></i>
                                Pass Card via Email
                            </h5>

                            <button
                                type="button"
                                class="close text-white"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                <span>&times;</span>
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="form-group">

                                <label for="emailCardTheme">
                                    <i class="fas fa-id-card mr-1"></i>
                                    Card Theme
                                </label>

                                <select
                                    id="emailCardTheme"
                                    class="form-control"
                                >
                                    <option value="1">Theme 1</option>
                                    <option value="2">Theme 2</option>
                                    <option value="3">Theme 3</option>
                                </select>

                            </div>

                            <div class="form-group">

                                <label for="emailCardRecipient">
                                    <i class="fas fa-envelope mr-1"></i>
                                    Recipient Email
                                </label>

                                <input
                                    type="email"
                                    id="emailCardRecipient"
                                    class="form-control"
                                    placeholder="example@gmail.com"
                                    autocomplete="email"
                                >

                                <small class="form-text text-muted">
                                    Gmail, Yahoo, Outlook and other email
                                    addresses are supported.
                                </small>

                            </div>

                            <div class="alert alert-info mb-0">

                                <i class="fas fa-info-circle mr-1"></i>

                                The card image will be generated and
                                downloaded first. Then your email
                                application will open so you can attach
                                the generated image.

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                <i class="fas fa-times mr-1"></i>
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger"
                                id="confirmPrintPreviewEmail"
                            >
                                <i class="fas fa-paper-plane mr-1"></i>
                                Continue
                            </button>

                        </div>

                    </div>
                </div>
            </div>
        `;

        $("body").append(modal);
    };
})(window, jQuery);
