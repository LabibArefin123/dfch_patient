<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patients List</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }


        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            color: #fff;
            display: inline-block;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .small-text {
            font-size: 10px;
            color: #555;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }
    </style>
</head>

<body>
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

    <h1>Patients List</h1>

    <table>
        <thead>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $index => $patient)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $patient->patient_code }}</td>
                    <td>
                        <strong>{{ $patient->patient_name }}</strong><br>
                        <span class="small-text">Father: {{ $patient->patient_f_name ?? 'N/A' }}</span><br>
                        <span class="small-text">Mother: {{ $patient->patient_m_name ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ ucfirst($patient->gender) }}</td>
                    <td>
                        {{ $patient->phone_1 ?? 'N/A' }}<br>
                        <span class="small-text">Alt: {{ $patient->phone_2 ?? 'N/A' }}</span><br>
                        <span class="small-text">Father: {{ $patient->phone_f_1 ?? 'N/A' }}</span><br>
                        <span class="small-text">Mother: {{ $patient->phone_m_1 ?? 'N/A' }}</span>
                    </td>
                    <td>
                        @if ($patient->location_type == 1)
                            {{ $patient->location_simple }}
                        @elseif ($patient->location_type == 2)
                            {{ $patient->city }}, {{ $patient->district }}
                        @else
                            {{ $patient->country }}
                        @endif
                    </td>
                    <td>
                        @if ($patient->is_recommend)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($patient->date_of_patient_added)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Total Patients: {{ $patients->count() }}</p>
</body>

</html>
