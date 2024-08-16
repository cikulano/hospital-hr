<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employee Salary Report</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table, tr, td {
            padding: 10px;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: middle;
        }

        .container {
            padding: 0;
        }

        .payslip-title {
            margin-bottom: 20px;
            text-align: center;
            text-decoration: underline;
            text-transform: uppercase;
            font-size: 20px;
        }

        .personal-info, .salary-info {
            margin-bottom: 20px;
        }

        .personal-info table, .salary-info table {
            border: 1px solid #ddd;
            width: 100%;
        }

        .personal-info td, .salary-info td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        .personal-info td {
            font-weight: bold;
            font-size: 14px;
        }

        .salary-info td {
            text-align: right;
            font-size: 14px;
        }

        .salary-info .header {
            font-weight: bold;
            text-align: left;
            font-size: 16px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
        }

        /* Styling for the two-column layout */
        .personal-info .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .personal-info .info-row div {
            width: 48%;
        }

        .personal-info .info-row div strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Payslip Title -->
        <div class="payslip-title">
            <h4>Payslip for the month of {{ \Carbon\Carbon::now()->format('F Y') }}</h4>
        </div>

        <!-- Personal Information -->
        <div class="personal-info">
            <h4>Personal Information</h4>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>{{ $users->name }}</td>
                    <td>NoPeg:</td>
                    <td>{{ $users->user_id }}</td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td>{{ $users->position }}</td>
                    <td>Department:</td>
                    <td>{{ $users->department }}</td>
                </tr>
            </table>
        </div>

        <!-- Salary Information -->
        <div class="salary-info">
            <h4>Salary Details</h4>
            <table>
                <tr>
                    <td class="header">Description</td>
                    <td class="header">Amount</td>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td>Rp {{ number_format($users->basic, 2) }}</td>
                </tr>
                <tr>
                    <td>House Rent Allowance (H.R.A.)</td>
                    <td>Rp {{ number_format($users->hra, 2) }}</td>
                </tr>
                <tr>
                    <td>Other Allowances</td>
                    <td>Rp {{ number_format($users->basic, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Salary</strong></td>
                    <td><strong>Rp {{ number_format($users->basic, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>SDM RSPJ</p>
        </div>
    </div>
</body>
</html>
