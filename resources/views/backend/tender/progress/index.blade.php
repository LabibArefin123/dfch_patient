@extends('adminlte::page')

@section('title', 'Progress Tenders List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h1 class="mb-2 fw-bold">Progress Tender List</h1>

        </div>

        <a href="{{ route('tender_progress.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table id="progessTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th class="text-center">Tender Number</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Publication Date</th>
                        <th class="text-center">Submission Date</th>
                        <th class="text-center">Work Order/NOA No</th>
                        <th class="text-center">Work Order/NOA Date</th>
                        <th class="text-center">Awarded Date</th>
                        <th class="text-center">Delivery Type</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="mt-4" style="height:50px;"></div>
@stop

@section('js')
    <script>
        $(function() {
            const table = $('#progessTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ajax: '{{ route('tender_progress.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tender_no',
                        name: 'tender_no'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'publication_date',
                        name: 'publication_date'
                    },
                    {
                        data: 'submission_date',
                        name: 'submission_date'
                    },
                    {
                        data: 'workorder_no',
                        name: 'workorder_no'
                    },
                    {
                        data: 'workorder_date',
                        name: 'workorder_date'
                    },
                    {
                        data: 'awarded_date',
                        name: 'awarded_date'
                    },
                    {
                        data: 'delivery_type',
                        name: 'delivery_type'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },

                    {
                        data: 'action',
                        name: 'action',
                    }

                ]
            });


        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('progressPieChart').getContext('2d');

            const chartData = @json($statuses); // Includes 'all' and each tender ID

            const selector = document.getElementById('tenderSelector');
            const legendContainer = document.getElementById('customLegend');

            const colors = ['#6c757d', '#0d6efd', '#198754'];
            const labels = ['Not Started', 'Ongoing', 'Completed'];

            function getChartData(id) {
                const data = chartData[id] || {
                    'Not Started': 0,
                    'Ongoing': 0,
                    'Completed': 0
                };
                return labels.map(label => data[label] || 0);
            }

            function updateLegend(data) {
                legendContainer.innerHTML = labels.map((label, index) => {
                    return `<div class="mb-1">
                    <span style="color:${colors[index]}; font-weight:bold;">●</span>
                    ${label}: <strong>${data[index]}</strong>
                </div>`;
                }).join('');
            }

            const chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: getChartData('all'),
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Tender Progress Overview'
                        }
                    }
                }
            });

            updateLegend(getChartData('all'));

            selector.addEventListener('change', function() {
                const selected = this.value;
                const newData = getChartData(selected);
                chart.data.datasets[0].data = newData;
                chart.update();
                updateLegend(newData);
            });
        });
    </script>

@endsection
