<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $client->client_name }} - Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $client->client_name }}</h2>
        <p>Report for {{ $month }} {{ $year }}</p>
        <p>Generated on: {{ $generated_at }}</p>
    </div>

    <div class="section">
        <div class="section-title">Client Information</div>
        <div class="info-row">
            <span class="info-label">Client Name:</span>
            <span>{{ $client->client_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Contact Person:</span>
            <span>{{ $client->contact_person }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $client->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span>{{ $client->phone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Address:</span>
            <span>{{ $client->address }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Employee List</div>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->joining_date->format('d M Y') }}</td>
                    <td>{{ ucfirst($employee->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <div class="section-title">Attendance Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Total Days</th>
                    <th>Working Days</th>
                    <th>Holidays</th>
                    <th>Absent Days</th>
                    <th>Applied Leaves</th>
                    <th>Present Days</th>
                    <th>Payable Days</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendance as $record)
                <tr>
                    <td>{{ $record['employee_id'] }}</td>
                    <td>{{ $record['employee_name'] }}</td>
                    <td>{{ $record['total_days'] }}</td>
                    <td>{{ $record['working_days'] }}</td>
                    <td>{{ $record['holidays'] }}</td>
                    <td>{{ $record['absent_days'] }}</td>
                    <td>{{ $record['applied_leaves'] }}</td>
                    <td>{{ $record['present_days'] }}</td>
                    <td>{{ $record['payable_days'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <div class="section-title">Payroll Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Basic + DA</th>
                    <th>HRA</th>
                    <th>Medical</th>
                    <th>Special</th>
                    <th>Conveyance</th>
                    <th>PF</th>
                    <th>ESI</th>
                    <th>PT</th>
                    <th>TDS</th>
                    <th>Advance</th>
                    <th>Total Earnings</th>
                    <th>Total Deductions</th>
                    <th>Net Payable</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payroll as $record)
                <tr>
                    <td>{{ $record['employee_id'] }}</td>
                    <td>{{ $record['employee_name'] }}</td>
                    <td>{{ number_format($record['basic_da'], 2) }}</td>
                    <td>{{ number_format($record['hra'], 2) }}</td>
                    <td>{{ number_format($record['medical_allowance'], 2) }}</td>
                    <td>{{ number_format($record['special_allowance'], 2) }}</td>
                    <td>{{ number_format($record['conveyance'], 2) }}</td>
                    <td>{{ number_format($record['pf'], 2) }}</td>
                    <td>{{ number_format($record['esi'], 2) }}</td>
                    <td>{{ number_format($record['pt'], 2) }}</td>
                    <td>{{ number_format($record['tds'], 2) }}</td>
                    <td>{{ number_format($record['advance'], 2) }}</td>
                    <td>{{ number_format($record['total_earnings'], 2) }}</td>
                    <td>{{ number_format($record['total_deductions'], 2) }}</td>
                    <td>{{ number_format($record['net_payable'], 2) }}</td>
                    <td>{{ ucfirst($record['status']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
