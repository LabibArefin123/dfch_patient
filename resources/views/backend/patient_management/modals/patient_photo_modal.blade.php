<div class="modal fade" id="patientImageModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    <i class="fas fa-user-circle"></i>
                    Patient Information
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-5">

                        <div class="border rounded p-2 text-center">

                            <img id="modalPatientPhoto" src="" class="img-fluid rounded"
                                style="height:420px;width:100%;object-fit:contain;background:#f8f9fa;">

                        </div>

                    </div>

                    <div class="col-md-7">

                        <table class="table table-bordered mb-0">

                            <tr>
                                <th width="35%">Name</th>
                                <td id="modalPatientName"></td>
                            </tr>

                            <tr>
                                <th>Patient Code</th>
                                <td id="modalPatientCode"></td>
                            </tr>

                            <tr>
                                <th>Age</th>
                                <td id="modalPatientAge"></td>
                            </tr>

                            <tr>
                                <th>Gender</th>
                                <td id="modalPatientGender"></td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td id="modalPatientPhone"></td>
                            </tr>

                            <tr>
                                <th>Date Added</th>
                                <td id="modalPatientDate"></td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
