<div class="col-12">

    <div class="patient-section-card patient-photo-card">

        <div class="section-header">

            <div>

                <h5>
                    <i class="fas fa-camera text-info"></i>
                    Patient Profile Photo
                </h5>

                <span>
                    Upload and manage patient profile image
                </span>

            </div>

            <span class="section-badge photo-badge">
                Profile
            </span>

        </div>

        <div class="row align-items-center">

            <div class="col-lg-5 text-center">

                <div class="patient-avatar-wrapper">

                    <img id="mainPreview"
                        src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                            ? asset($patient->patient_photo)
                            : asset('uploads/images/default.jpg') }}"
                        class="patient-main-avatar">

                </div>

            </div>

            <div class="col-lg-7">

                <div class="photo-info-box">

                    <h5>
                        {{ $patient->patient_name }}
                    </h5>

                    <p>
                        Update patient photo and view detailed image information.
                    </p>

                    <div class="mt-4">

                        <input type="file" name="patient_photo" id="hiddenPhotoInput" hidden>

                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                            data-target="#photoModal">

                            <i class="fas fa-upload mr-1"></i>
                            Change Photo

                        </button>

                        <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#patientPhotoInfoModal">

                            <i class="fas fa-search mr-1"></i>
                            View Details

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
