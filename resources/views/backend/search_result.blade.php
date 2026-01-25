@php
    use Carbon\Carbon;
    function formatDateSafe($date)
    {
        try {
            return Carbon::parse($date)->format('d F Y');
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
    function formatTime($time)
        {
        try {
            return Carbon::parse($time)->format('h:i A');
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
@endphp

@extends('adminlte::page')

@section('title', 'Search Result')

@section('content_header')
    <h1>Search Result</h1>
@stop

@section('content')
    @if ($data)
        <div class="card">
            <div class="card-header bg-primary text-white">
                @switch($type)
                    @case('tender')
                        <strong>Tender No: {{ $data->tender_no }} for {{ $data->title }}</strong>
                    @break

                    @case('participate')
                        <strong>Offer No: {{ $data->offer_no }} for Participated Tender ({{ $data->tender->title }})</strong>
                    @break

                    @case('awarded')
                        <strong>Workorder No: {{ $data->workorder_no }} for Awarded Tender
                            ({{ $data->tenderParticipate->tender->title }})</strong>
                    @break

                    @case('completed')
                        <strong>Workorder No: {{ $data->workorder_no }} for Completed Tender
                            ({{ $data->tenderProgress->tenderAwarded->tenderParticipate->tender->title }})</strong>
                    @break

                    @default
                        <strong>Unknown Type</strong>
                @endswitch
            </div>

            <div class="card-body">
                <div class="row">
                    @switch($type)
                        @case('tender')
                            @include('backend.search_type.tender.tender')
                        @break

                        @case('participate')
                            @include('backend.search_type.participated_tender.participated_tender')
                        @break

                        @case('awarded')
                             @include('backend.search_type.awarded_tender.awarded_tender')
                        @break

                        @case('completed')
                           @include('backend.search_type.completed_tender.completed_tender')
                        @break

                        @default
                            <div class="col-12">
                                <p>No detailed view available for this type.</p>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body" style="height:50px;">
                <!-- Intentionally left blank -->
            </div>
        </div>
    @else
        <div class="alert alert-warning">No result data found for the selected item.</div>
    @endif
    @if (isset($debug))
        <script>
            console.group('🔍 Search Result Debug');
            console.log('Tender:', @json($debug['tender']));
            console.log('Type:', @json($debug['type']));
            console.log('Lifecycle:', @json($debug['lifecycle']));
            console.log('Data Object:', @json($debug['data_object']));
            console.log('Counts:', @json($debug['counts']));
            console.groupEnd();
        </script>
    @endif
@stop
