<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daily Patient Report</title>
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
    </style>
</head>

<body>
    <h3>Daily Patient Report - {{ date('Y-m-d') }}</h3>
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
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->location }}</td>
                    <td>{{ $patient->is_recommend ? 'Yes' : 'No' }}</td>
                    <td>{{ $patient->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
