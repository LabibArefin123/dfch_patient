@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $title }}</h1>

        <div>
            <button class="btn btn-info btn-sm mr-2" data-toggle="collapse" data-target="#filterSection">
                <i class="fas fa-filter"></i> Filter
            </button>

            <a href="#" id="downloadPdfBtn" target="_blank" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            {{-- FILTER SECTION --}}
            <div class="collapse mb-3" id="filterSection">
                <div class="card card-body">
                    <form id="filterForm">
                        @yield('filters')
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <table class="table table-striped table-hover text-nowrap w-100" id="reportTable">
                <thead class="table-dark">
                    @yield('table_header')
                </thead>
            </table>

        </div>
    </div>

    {{-- Reusable Confirm Modal --}}
    @include('backend.report_management.patient.partials.confirm_pdf_modal')
@stop

@section('js')
    <script>
        $(function() {

            let table = $('#reportTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ $ajaxRoute }}",
                    data: function(d) {
                        $('#filterForm').serializeArray().forEach(function(item) {
                            d[item.name] = item.value;
                        });
                    }
                },
                columns: {!! $columns !!}
            });

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#downloadPdfBtn').on('click', function(e) {
                e.preventDefault();
                let params = $('#filterForm').serialize();
                window.open("{{ $pdfRoute }}?" + params, '_blank');
            });

        });
    </script>

    {{-- Modal Auto Trigger --}}
    @if (session('confirm_pdf'))
        <script>
            $(document).ready(function() {
                $('#warningMessage').modal('show');

                $('#confirmPdfBtn').on('click', function() {
                    let params = new URLSearchParams(@json(session()->all()));
                    params.set('confirm', 1);
                    window.open("{{ $pdfRoute }}?" + params.toString(), '_blank');
                    $('#warningMessage').modal('hide');
                });
            });
        </script>
    @endif
@stop
