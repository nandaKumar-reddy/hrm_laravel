<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $employee->employee_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .payslip-title {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .payslip-period {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .employee-details {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .signatures {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">{{ $employee->client->name ?? 'Company Name' }}</div>
            <div class="payslip-title">SALARY SLIP</div>
            <div class="payslip-period">For the Month of {{ $month }}</div>
        </div>

        <div class="employee-details">
            <table>
                <tr>
                    <td><strong>Employee ID:</strong> {{ $employee->employee_id }}</td>
                    <td><strong>Name:</strong> {{ $employee->full_name }}</td>
                </tr>
                <tr>
                    <td><strong>Designation:</strong> {{ $employee->designation }}</td>
                    <td><strong>Department:</strong> {{ $employee->department }}</td>
                </tr>
                <tr>
                    <td><strong>PF Number:</strong> {{ $employee->pf_number }}</td>
                    <td><strong>ESI Number:</strong> {{ $employee->esi_number }}</td>
                </tr>
                <tr>
                    <td><strong>UAN:</strong> {{ $employee->uan }}</td>
                    <td><strong>PAN:</strong> {{ $employee->pan_number }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th colspan="2">Attendance Details</th>
                </tr>
                <tr>
                    <td>Total Days</td>
                    <td>{{ $attendance->total_days ?? Carbon\Carbon::createFromDate($payroll->year, $payroll->month)->daysInMonth }}</td>
                </tr>
                <tr>
                    <td>Payable Days</td>
                    <td>{{ $attendance->payable_days ?? Carbon\Carbon::createFromDate($payroll->year, $payroll->month)->daysInMonth }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th>Earnings</th>
                    <th>Amount (₹)</th>
                    <th>Deductions</th>
                    <th>Amount (₹)</th>
                </tr>
                <tr>
                    <td>Basic + DA</td>
                    <td>{{ number_format($payroll->basic_da, 2) }}</td>
                    <td>PF</td>
                    <td>{{ number_format($payroll->pf, 2) }}</td>
                </tr>
                <tr>
                    <td>HRA</td>
                    <td>{{ number_format($payroll->hra, 2) }}</td>
                    <td>ESI</td>
                    <td>{{ number_format($payroll->esi, 2) }}</td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td>{{ number_format($payroll->medical_allowance, 2) }}</td>
                    <td>PT</td>
                    <td>{{ number_format($payroll->pt, 2) }}</td>
                </tr>
                <tr>
                    <td>Special Allowance</td>
                    <td>{{ number_format($payroll->special_allowance, 2) }}</td>
                    <td>TDS</td>
                    <td>{{ number_format($payroll->tds, 2) }}</td>
                </tr>
                <tr>
                    <td>Conveyance</td>
                    <td>{{ number_format($payroll->conveyance, 2) }}</td>
                    <td>Advance</td>
                    <td>{{ number_format($payroll->advance, 2) }}</td>
                </tr>
                <tr>
                    <td>Statutory Bonus</td>
                    <td>{{ number_format($payroll->statutory_bonus, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>EL Encashment</td>
                    <td>{{ number_format($payroll->el_encashment, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Other Allowance</td>
                    <td>{{ number_format($payroll->other_allowance, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Incentives</td>
                    <td>{{ number_format($payroll->incentives, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Overtime</td>
                    <td>{{ number_format($payroll->ot, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="total-row">
                    <td>Total Earnings</td>
                    <td>{{ number_format($payroll->total_earnings, 2) }}</td>
                    <td>Total Deductions</td>
                    <td>{{ number_format($payroll->deductions_total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th colspan="2">Net Payment Details</th>
                </tr>
                <tr>
                    <td><strong>Net Salary Payable:</strong></td>
                    <td><strong>₹ {{ number_format($payroll->net_payable, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Amount in Words:</td>
                    <td>{{ ucwords(NumberFormatter::create('en_IN', NumberFormatter::SPELLOUT)->format($payroll->net_payable)) }} Rupees Only</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th colspan="2">Payment Information</th>
                </tr>
                <tr>
                    <td>Bank Name:</td>
                    <td>{{ $employee->bank_name }}</td>
                </tr>
                <tr>
                    <td>Account Number:</td>
                    <td>{{ $employee->account_number }}</td>
                </tr>
                <tr>
                    <td>IFSC Code:</td>
                    <td>{{ $employee->ifsc_code }}</td>
                </tr>
            </table>
        </div>

        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div>Employee Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div>Authorized Signatory</div>
            </div>
        </div>

        <div class="footer">
            <p>This is a computer generated payslip and does not require signature</p>
            <p>For any queries regarding this payslip, please contact HR Department</p>
        </div>
    </div>
</body>
</html>
