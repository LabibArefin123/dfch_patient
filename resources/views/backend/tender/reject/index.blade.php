@extends('adminlte::page')

@section('title', 'Rejected Tenders')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Rejected Tenders</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th class="text-center">Tender Number</th>
                        <th class="text-center">Tender Title</th>
                        <th class="text-center">Deno</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Offer Price</th>
                        <th class="text-center">Offer Validity</th>
                        <th class="text-center">Tender Security</th>
                        <th class="text-center">TS Expiry Date</th>
                        <th class="text-center">FY</th>
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Position</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rejectedTenders as $index => $pt)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $pt->tender->tender_no }}</td>
                            <td class="text-center" style="min-width: 250px;">
                                <a href="{{ route('tender.mytender', $pt->tender->id) }}">
                                    {{ $pt->tender->title }}
                                </a>
                            </td>
                            <td class="text-center">{{ $pt->deno }}</td>
                            <td class="text-center">{{ $pt->qty }}</td>
                            <td class="text-center">{{ number_format($pt->offered_price, 2) }}</td>
                            <td class="text-center">{{ $pt->offer_validity }}</td>
                            <td class="text-center">{{ number_format($pt->security_price, 2) }}</td>
                            <td class="text-center">{{ optional($pt->expiry_date)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $pt->tender->financial_year }}</td>
                            <td class="text-center">{{ $pt->company_name }}</td>
                            <td class="text-center">{{ $pt->position }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">No rejected tenders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
