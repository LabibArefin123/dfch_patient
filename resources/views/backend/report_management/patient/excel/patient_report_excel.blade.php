<table>
    <thead>
        <tr>
            <th colspan="12"><strong>{{ $title }}</strong></th>
        </tr>
        <tr>
            <th>#</th>
            <th>Patient Code</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Alt Phone</th>
            <th>Father Phone</th>
            <th>Mother Phone</th>
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
                <td>{{ $patient->patient_name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->gender }}</td>
                <td>{{ $patient->phone_1 }}</td>
                <td>{{ $patient->phone_2 }}</td>
                <td>{{ $patient->phone_f_1 }}</td>
                <td>{{ $patient->phone_m_1 }}</td>
                <td>{{ $patient->location }}</td>
                <td>{{ $patient->is_recommend ? 'Yes' : 'No' }}</td>
                <td>{{ $patient->date_of_patient_added }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
