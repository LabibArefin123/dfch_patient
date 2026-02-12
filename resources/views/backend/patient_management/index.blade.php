@extends('adminlte::page')

@section('title', 'Patients')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Patients</h1>
        <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
            Add Patient
        </a>
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

    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {

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

                        // ✅ Update counts dynamically
                        $('#childCount').text(json.childPatients);
                        $('#adultCount').text(json.adultPatients);
                        $('#seniorCount').text(json.seniorPatients);

                        return json.data;
                    }

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        name: 'location',
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

            $('#dateFilter').on('change', function() {

                if ($(this).val() === 'custom') {
                    $('#startDateDiv').removeClass('d-none');
                    $('#endDateDiv').removeClass('d-none');
                } else {
                    $('#startDateDiv').addClass('d-none');
                    $('#endDateDiv').addClass('d-none');
                    $('input[name=from_date]').val('');
                    $('input[name=to_date]').val('');
                }

            });

            // Prevent normal form submit & reload table
            $('form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

        });
    </script>
@endsection
