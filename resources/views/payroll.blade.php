<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll</title>
</head>
<style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 2px solid black;
        }

        th {
            background-color: gray;
            color: black;
        }
</style>
<body>
    <h1>Payroll</h1>
    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Gross Salary</th> <!-- Display Gross Salary -->
                <th>Deductions</th>
                <th>Cash Advance</th>
                <th>Netpay</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <!-- Display Gross Salary -->
                    <td>{{ number_format($employee->payroll->gross_salary, 2) }}</td>
                    <td>
                        @if($employee->deduction_name)
                            {{ $employee->deduction_name }} ({{ number_format($employee->total_deductions, 2) }})
                        @else
                            No deductions
                        @endif
                    </td>
                    <td>
                        <!-- Display the approved cash advance if available, otherwise show 0 -->
                        {{ number_format($employee->approved_cash_advance ?? 0, 2) }}
                    </td>
                    <td>{{ number_format($employee->payroll->net_salary, 2) }}</td>
                    <td>Active</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</body>


    
</body>
</html>
