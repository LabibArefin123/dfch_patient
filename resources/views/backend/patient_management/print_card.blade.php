<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Patient Card</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2c3e50;
           
        }

        .card {
            max-width: 95%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #3498db;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #3498db;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .org-name {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .org-info {
            font-size: 11px;
            color: #555;
        }

        .generated-date {
            font-size: 10px;
            color: #777;
        }

        .photo-box {
            width: 160px;
            height: 160px;
            border: 2px solid #3498db;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 10px;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .patient-name {
            font-size: 20px;
            font-weight: bold;
            color: #2980b9;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 150px;
            color: #34495e;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            color: #2980b9;
            padding: 6px 0;
            border-bottom: 1px solid #ccc;
            margin-top: 15px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .welcome-text {
            font-size: 12px;
            margin-top: 15px;
            color: #555;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="card">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <td width="30%">
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
                        <img src="{{ $imagePath }}" style="width:220px; height:auto;">
                    @else
                        <div style="font-size:14px; color:#777;">No Logo</div>
                    @endif
                </td>
                <td width="70%" align="right">
                    <div class="org-info">{{ $organization->organization_location ?? '' }}</div>
                    <div class="org-info">
                        Phone: {{ $organization->phone_1 ?? '' }}
                        @if (!empty($organization->phone_2))
                            | {{ $organization->phone_2 }}
                        @endif
                    </div>
                    <div class="generated-date">
                        Generated: {{ \Carbon\Carbon::now()->format('d F Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- MAIN CONTENT -->
        <table width="100%">
            <tr>
                <!-- LEFT PHOTO -->
                <td width="30%" align="center">
                    <div class="photo-box">
                        <img
                            src="{{ $patient->photo_path ? public_path($patient->photo_path) : public_path('images/patient_placeholder.png') }}">
                    </div>
                </td>

                <!-- RIGHT DETAILS -->
                <td width="70%">
                    <div class="patient-name">{{ $patient->patient_name }}</div>

                    <table class="info-table">
                        <tr>
                            <td colspan="2" class="section-title">Patient Details</td>
                        </tr>
                        <tr>
                            <td class="label">Patient ID</td>
                            <td>{{ $patient->patient_code ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Father Name</td>
                            <td>{{ $patient->patient_f_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Mother Name</td>
                            <td>{{ $patient->patient_m_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Age</td>
                            <td>{{ $patient->age ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Gender</td>
                            <td>{{ ucfirst($patient->gender) ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="section-title">Contact Information</td>
                        </tr>
                        <tr>
                            <td class="label">Primary Phone</td>
                            <td>{{ $patient->phone_1 ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alternate Phone</td>
                            <td>{{ $patient->phone_2 ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- WELCOME MESSAGE -->
        <div class="welcome-text">
            We are committed to providing you with compassionate and quality healthcare. Please keep this card for
            future visits.
        </div>

        <!-- FOOTER -->
        <div class="footer">
            Authorized Signature ___________________
        </div>

    </div>

</body>

</html>
