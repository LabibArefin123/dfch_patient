@extends('adminlte::page')

@section('title', 'Patients')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Patients</h1>

        <div class="d-flex gap-2">
            {{-- Add Patient (Primary Action) --}}
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Patient
            </a>

            {{-- More Actions Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item export-excel" href="{{ route('patients.export.excel') }}">
                        <i class="fas fa-file-excel text-success"></i> Export Excel
                    </a>

                    <a class="dropdown-item export-pdf" href="{{ route('patients.export.pdf') }}">
                        <i class="fas fa-file-pdf text-danger"></i> Export PDF
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item import-excel" href="{{ route('patients.import.excel') }}">
                        <i class="fas fa-upload"></i> Import Excel
                    </a>

                    <a class="dropdown-item import-word" href="{{ route('patients.import.word') }}">
                        <i class="fas fa-upload"></i> Import Word
                    </a>

                    <a class="dropdown-item" href="{{ route('patients.print') }}">
                        <i class="fas fa-print"></i> Print
                    </a>

                </div>
            </div>
        </div>
    </div>
@stop


@section('content')
    {{-- Filter Form --}}
    @include('backend.patient_management.filter.filter')

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap w-100" id="patientsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="importFileModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="importFileForm" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="modal-content p-0 overflow-hidden">

                    <div class="row g-0">

                        <!-- LEFT SIDE -->
                        <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">

                            <label for="importFileInput"
                                class="w-100 border border-2 border-primary rounded text-center p-5 cursor-pointer"
                                style="border-style: dashed; transition: 0.3s;">

                                <div class="mb-3">
                                    <i class="fas fa-file-excel fa-4x text-success"></i>
                                </div>

                                <h5 class="fw-bold mb-2">Upload Excel File</h5>
                                <p class="text-muted small mb-0">
                                    Click here to select file
                                </p>

                                <input type="file" name="file" id="importFileInput" class="d-none" accept=".xlsx,.xls"
                                    required>
                            </label>

                        </div>

                        <!-- RIGHT SIDE -->
                        <div class="col-md-6 d-flex flex-column justify-content-center p-5">

                            <h4 id="importModalTitle" class="mb-4">
                                Import Patients
                            </h4>

                            <div class="d-grid gap-3">

                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload me-2"></i> Upload
                                </button>

                                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                            </div>

                            <!-- Progress -->
                            <div class="mt-5 text-center">

                                <div class="position-relative d-inline-block">
                                    <svg width="120" height="120">
                                        <circle cx="60" cy="60" r="52" stroke="#e6e6e6" stroke-width="10"
                                            fill="none" />
                                        <circle id="importProgressCircle" cx="60" cy="60" r="52"
                                            stroke="#007bff" stroke-width="10" fill="none" stroke-dasharray="327"
                                            stroke-dashoffset="327" stroke-linecap="round" transform="rotate(-90 60 60)" />
                                    </svg>
                                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="top:0; left:0;">
                                        <span id="importProgressPercent"
                                            style="font-size: 20px; font-weight: bold;">0%</span>
                                    </div>
                                </div>

                                <p id="importProgressText" class="mt-3 text-muted">
                                    Waiting for upload...
                                </p>

                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Start of No Filter Warning Modal -->
    <div class="modal fade" id="noFilterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-exclamation-triangle"></i>
                        Filter Required
                    </h5>
                    <button type="button" class="close text-white" onclick="$('#noFilterModal').modal('hide')">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <p class="mb-0">
                        Please choose at least one filter before exporting Excel or PDF.
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" onclick="$('#noFilterModal').modal('hide')">
                        OK
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- End of No Filter Warning Modal -->

    <!-- Progress Modal -->
    <div class="modal fade" id="fileProcessModal" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">

                <h5 id="processTitle" class="mb-4">Processing...</h5>

                <div class="position-relative d-inline-block">
                    <svg width="150" height="150">
                        <circle cx="75" cy="75" r="65" stroke="#e6e6e6" stroke-width="10"
                            fill="none" />
                        <circle id="progressCircle" cx="75" cy="75" r="65" stroke="#28a745"
                            stroke-width="10" fill="none" stroke-dasharray="408" stroke-dashoffset="408"
                            stroke-linecap="round" transform="rotate(-90 75 75)" />
                    </svg>

                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                        style="top:0; left:0;">
                        <span id="progressPercent" style="font-size: 22px; font-weight: bold;">0%</span>
                    </div>
                </div>

                <p id="processText" class="mt-3 text-muted">Please wait...</p>

            </div>
        </div>
    </div>
    <iframe id="downloadFrame" style="display:none;"></iframe>
    {{-- <iframe id="downloadFrame" style="display:none;"></iframe> --}}

    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script>
        // ===============================
        // Progress Modal Logic (Fixed)
        // ===============================

        let progressInterval = null;
        let circle = null;
        let radius = 65;
        let circumference = 2 * Math.PI * radius;

        function showProcessModal(title, text, color = '#28a745') {

            $('#processTitle').text(title);
            $('#processText').text(text);

            circle = document.getElementById('progressCircle');

            // Reset previous interval if exists
            if (progressInterval !== null) {
                clearInterval(progressInterval);
                progressInterval = null;
            }

            // Reset progress
            $('#progressPercent').text('0%');
            circle.style.stroke = color;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = circumference;

            $('#fileProcessModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            animateProgress();
        }

        function animateProgress() {
            let percent = 0;

            progressInterval = setInterval(function() {

                percent += 2;

                if (percent >= 100) {
                    percent = 100;
                    clearInterval(progressInterval);
                    progressInterval = null;

                    setTimeout(function() {
                        $('#fileProcessModal').modal('hide');
                    }, 400);
                }

                let offset = circumference - (percent / 100 * circumference);
                circle.style.strokeDashoffset = offset;

                $('#progressPercent').text(percent + '%');

            }, 40);
        }
    </script>

    <script>
        $(function() {

            // ===============================
            // URL Filter Auto Fill
            // ===============================

            const urlParams = new URLSearchParams(window.location.search);

            const presetFilters = {
                gender: urlParams.get('gender'),
                is_recommend: urlParams.get('is_recommend'),
                location_type: urlParams.get('location_type'),
                location_value: urlParams.get('location_value'),
                date_filter: urlParams.get('date_filter'),
                from_date: urlParams.get('from_date'),
                to_date: urlParams.get('to_date'),
            };

            Object.keys(presetFilters).forEach(key => {
                if (presetFilters[key] !== null) {
                    $(`[name="${key}"]`).val(presetFilters[key]);
                }
            });

            if (presetFilters.date_filter === 'custom') {
                $('#startDateDiv, #endDateDiv').removeClass('d-none');
            }

            // ===============================
            // DataTable
            // ===============================

            var table = $('#patientsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('patients.index') }}",
                    data: function(d) {
                        d.gender = $('select[name=gender]').val();
                        d.is_recommend = $('select[name=is_recommend]').val();
                        d.location_type = $('select[name=location_type]').val();
                        d.location_value = $('input[name=location_value]').val();
                        d.date_filter = $('select[name=date_filter]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    },
                    dataSrc: function(json) {
                        $('#childCount').text(json.childPatients ?? 0);
                        $('#adultCount').text(json.adultPatients ?? 0);
                        $('#seniorCount').text(json.seniorPatients ?? 0);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'patient_code',
                        name: 'patient_code'
                    },
                    {
                        data: 'name',
                        name: 'patient_name'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'phone',
                        name: 'phone_1'
                    },
                    {
                        data: 'location',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'is_recommend',
                        name: 'is_recommend'
                    },
                    {
                        data: 'date',
                        name: 'date_of_patient_added'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // ===============================
            // Date Filter Toggle
            // ===============================

            $('select[name=date_filter]').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#startDateDiv, #endDateDiv').removeClass('d-none');
                } else {
                    $('#startDateDiv, #endDateDiv').addClass('d-none');
                    $('input[name=from_date], input[name=to_date]').val('');
                }
            });

            // ===============================
            // Export / Import Handlers
            // ===============================
            function hasFilterApplied() {

                let gender = $('select[name="gender"]').val();
                let locationType = $('select[name="location_type"]').val();
                let locationValue = $('input[name="location_value"]').val();
                let dateFilter = $('select[name="date_filter"]').val();
                let fromDate = $('input[name="from_date"]').val();
                let toDate = $('input[name="to_date"]').val();

                if (
                    gender ||
                    locationType ||
                    locationValue ||
                    dateFilter ||
                    fromDate ||
                    toDate
                ) {
                    return true;
                }

                return false;
            }


            function handleExport(selector, title, text, color) {

                $(document).on('click', selector, function(e) {

                    e.preventDefault();

                    if (!hasFilterApplied()) {
                        $('#noFilterModal').modal('show');
                        return;
                    }

                    let url = $(this).attr('href');

                    showProcessModal(title, text, color);

                    setTimeout(function() {
                        $('#downloadFrame').attr('src', url);
                    }, 500);

                    setTimeout(function() {
                        $('#fileProcessModal').modal('hide');
                    }, 2500);
                });
            }


            handleExport('.export-excel', 'Exporting Excel', 'Preparing Excel file...', '#28a745');
            handleExport('.export-pdf', 'Exporting PDF', 'Preparing PDF file...', '#dc3545');

            // --- Import handler ---
            $(document).on('click', '.import-excel, .import-word', function(e) {
                e.preventDefault();
                let route = $(this).attr('href'); // route attribute
                let title = $(this).hasClass('import-excel') ? 'Import Excel' : 'Import Word';
                let color = $(this).hasClass('import-excel') ? '#007bff' : '#6f42c1';

                $('#importFileForm').attr('action', route);
                $('#importModalTitle').text(title);
                $('#importProgressCircle').css('stroke', color);
                $('#importProgressPercent').text('0%');
                $('#importProgressCircle').css('stroke-dashoffset', 327);

                $('#importFileModal').modal('show');
            });

            // --- Import form submit with modal progress ---
            $('#importFileForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = $(this).attr('action');

                let percent = 0;
                $('#importFileModal input, #importFileForm button').prop('disabled', true);

                let interval = setInterval(function() {
                    percent += 5;
                    if (percent > 100) percent = 100;
                    $('#importProgressPercent').text(percent + '%');
                    $('#importProgressCircle').css('stroke-dashoffset', 327 - (327 * percent /
                        100));
                }, 100);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        clearInterval(interval);
                        $('#importProgressPercent').text('100%');
                        setTimeout(() => {
                            $('#importFileModal').modal('hide');
                            location.reload();
                        }, 500);
                    },
                    error: function(err) {
                        clearInterval(interval);

                        if (err.responseJSON && err.responseJSON.errors) {
                            alert(err.responseJSON.errors.join("\n"));
                        } else {
                            alert('Upload failed. Please try again.');
                        }

                        $('#importFileModal input, #importFileForm button').prop('disabled',
                            false);
                    }

                });
            });

            // ===============================
            // Fix No Filter Modal Buttons
            // ===============================

            // Close button (X)
            $(document).on('click', '#noFilterModal .close', function() {
                $('#noFilterModal').modal('hide');
            });

            // OK button
            $(document).on('click', '#noFilterModal .btn-danger', function() {
                $('#noFilterModal').modal('hide');
            });

            // Remove stuck backdrop if any
            $('#noFilterModal').on('hidden.bs.modal', function() {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });

            // ===============================
            // Filter Submit
            // ===============================

            $('form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

        });
    </script>
@endsection
