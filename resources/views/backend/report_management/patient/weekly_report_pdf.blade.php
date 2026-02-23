<!DOCTYPE html>
<html>

<head>
    @php
        use Carbon\Carbon;
    @endphp
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
    <title>Weekly Patient Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }
    </style>
</head>

<body>

    {{-- Organization Header --}}
    <table width="100%" class="header-table">
        <tr>
            <td width="25%">
                @php
                    $imagePath = null;
                    if ($organization && $organization->organization_picture) {
                        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                            $fullPath = public_path(
                                'uploads/images/backend/organization/' .
                                    $organization->organization_picture .
                                    '.' .
                                    $ext,
                            );
                            if (file_exists($fullPath)) {
                                $imagePath = $fullPath;
                                break;
                            }
                        }
                    }
                @endphp

                @if ($imagePath)
                    <img src="{{ $imagePath }}" style="width:300px; height:60px;">
                @else
                    <span>No Logo</span>
                @endif
            </td>

            <td width="75%" style="text-align:right;">
                <h2 style="margin:0;">{{ $organization->name ?? 'Organization Name' }}</h2>
                <p style="margin:2px 0;">{{ $organization->organization_location ?? '' }}</p>
                <p style="margin:2px 0;">
                    Phone: {{ $organization->phone_1 ?? '' }}
                    @if (!empty($organization->phone_2))
                        | {{ $organization->phone_2 }}
                    @endif
                    @if (!empty($organization->land_phone_1))
                        | {{ $organization->land_phone_1 }}
                    @endif
                    @if (!empty($organization->land_phone_2))
                        | {{ $organization->land_phone_2 }}
                    @endif
                </p>
            </td>
        </tr>
    </table>

    {{-- Report Title --}}
    <h3>
        Weekly Patient Report
        @if (request()->filled('from_date') && request()->filled('to_date'))
            from {{ Carbon::parse(request()->from_date)->format('j F Y') }}
            to {{ Carbon::parse(request()->to_date)->format('j F Y') }}
        @endif
    </h3>

    {{-- Page Info --}}
    <table width="100%" class="header-table">
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Page:</strong> {{ $page }} of {{ $totalPages }} |
                <strong>Total Records:</strong> {{ $totalRecords }} (Current Total Record: {{ $totalRecords }})
            </td>
        </tr>
    </table>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Code</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Alt Phone</th>
                <th>Father</th>
                <th>Mother</th>
                <th>Location</th>
                <th>Recommended</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $index => $patient)
                <tr>
                    <td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
                    <td>{{ $patient->patient_code }}</td>
                    <td>{{ $patient->patient_name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->phone_1 }}</td>
                    <td>{{ $patient->phone_2 }}</td>
                    <td>{{ $patient->phone_f_1 }}</td>
                    <td>{{ $patient->phone_m_1 }}</td>
                    <td>
                        @if ($patient->location_type == 1)
                            {{ $patient->location_simple }}
                        @elseif($patient->location_type == 2)
                            {{ $patient->house_address }}, {{ $patient->city }}, {{ $patient->district }} -
                            {{ $patient->post_code }}
                        @else
                            {{ $patient->country }} <br><strong>Passport:</strong> {{ $patient->passport_no }}
                        @endif
                    </td>
                    <td>{{ $patient->is_recommend ? 'Yes' : 'No' }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->date_of_patient_added)->format('d-m-Y') }}
                        ({{ \Carbon\Carbon::parse($patient->date_of_patient_added)->format('d F Y') }})
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
