<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <style>
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        overflow: hidden;
        border-radius: 8px;
    }

    th, td {
        padding: 15px;
        text-align: center;
        font-size: 18px;
    }

    th {
        background-color: #3182ce;
        color: #ffffff;
        font-weight: bold;
        text-transform: uppercase;
        border-bottom: 2px solid #2b6cb0;
    }

    td {
        border-bottom: 1px solid #e2e8f0;
        color: #2d3748;
    }

    tr:hover {
        background-color: #f7fafc;
        cursor: pointer;
    }

    tr:nth-child(even) {
        background-color: #f0f4f8;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    @media (max-width: 768px) {
        table {
            width: 100%;
        }

        th, td {
            padding: 10px;
            font-size: 16px;
        }
    }
</style>
</head>
<body>

<h2 style="text-align: center;">Attendance Records</h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->employee_id }}</td>
                <td>{{ $attendance->employee->first_name . ' ' . $attendance->employee->last_name ?? 'N/A' }}</td>
                <td>{{ $attendance->check_in_time }}</td>
                <td>{{ $attendance->check_out_time ?? 'N/A' }}</td>
                <td>
                    <!-- Add action buttons if needed -->
                    <button>Edit</button>
                    <button>Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No attendance records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
