<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employee Salary Report</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            position: relative;
        }
        .header {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            max-width: 120px;
            max-height: 60px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .logo1 {
            max-width: 160px;
            max-height: 80px;
        }
        .company-info {
            text-align: center;
            flex-grow: 1;
        }
        .company-info h2 {
            color: #3498db;
            margin: 0;
            font-size: 20px;
        }
        .divider {
            border-top: 2px solid #3498db;
            margin: 10px 0;
        }

        .divider2 {
            border-top: 3px solid #28a745;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 4px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        .section-header {
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }
        .amount {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }
        .watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .watermark img {
            max-width: 60%;
            max-height: 60%;
            opacity: 0.1;
        }
        .personal-info {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .personal-info-item {
            width: 50%;
            margin-bottom: 5px;
        }
        .personal-title {
            font-weight: bold;
            padding-right: 5px; 
        }
        .salary-info-label {
            width: 70%;
            text-align: left;
        }
        .salary-info-value {
            width: 30%;
            text-align: right;
        }
        .summary-section {
            margin-top: 15px;
            border: 2px solid #3498db;
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Watermark and Logo -->
    <div class="watermark">
        <img src="{{ $logo2Src }}" alt="Watermark">
    </div>
    <div class="header">
        <img src="{{ $logo1Src }}" alt="Company Logo 1" class="logo logo1">
        <div class="company-info">
            <h2>Pay Slip</h2>
        </div>
        <img src="{{ $logo2Src }}" alt="Company Logo 2" class="logo">
    </div>

    <div class="divider"></div>

    <!-- Personal Information -->
    <div class="personal-info">
        <div class="personal-info-item">
            <span class="personal-title">Lokasi:</span>
            <span>{{ $users->department }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Nama Pekerja:</span>
            <span>{{ $users->name }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Periode Slip Upah:</span>
            <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM') }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Nopeg:</span>
            <span>{{ $users->user_id }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Salary Information -->
    <?php
        $lembur = (int)$users->da;
        $shift = (int)$users->hra;
        $transport = (int)$users->allowance;
        $onsite = (int)$users->medical_allowance;
        $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite + $transport;
        
        $pajak = (int)$users->tds;
        $JHT = (int)$users->basic * 0.02;
        $JP = (int)$users->basic * 0.01;
        $BPJSKes = (int)$users->basic * 0.01;
        $totalPotongan = $JHT + $JP + $BPJSKes;
        $total = $totalPendapatan - $totalPotongan ;
    ?>

    <!-- Pendapatan Information -->
    <div>
        <h4 class="section-header">Pendapatan</h4>
        <table>
            <tr>
                <td class="salary-info-label">THP</td>
                <td class="salary-info-value">Rp {{ number_format($users->basic) }}</td>
            </tr>
            <!-- <tr>
                <td class="salary-info-label">Upah Proporsional</td>
                <td class="salary-info-value">Rp {{ number_format($users->basic) }}</td>
            </tr> -->
            <tr>
                <td class="salary-info-label">Uang Lembur</td>
                <td class="salary-info-value">Rp {{ number_format($lembur) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Tunjangan Shift</td>
                <td class="salary-info-value">Rp {{ number_format($shift) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Transportasi</td>
                <td class="salary-info-value">Rp {{ number_format($transport) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Kompensasi Lain-lain</td>
                <td class="salary-info-value">Rp {{ number_format($onsite) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Pendapatan</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($totalPendapatan) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="divider2"></div>

    <!-- Potongan Information -->
    <div>
        <h4 class="section-header">Potongan</h4>
        <table>
            <tr>
                <td class="salary-info-label">BPJSTK JHT</td>
                <td class="salary-info-value">Rp {{ number_format($JHT) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJSTK JP</td>
                <td class="salary-info-value">Rp {{ number_format($JP) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJS Kesehatan</td>
                <td class="salary-info-value">Rp {{ number_format($BPJSKes) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Potongan</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($totalPotongan) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="divider2"></div>

    <!-- Pajak Information -->
    <div>
        <h4 class="section-header">Pajak</h4>
        <table>
            <tr>
                <td class="salary-info-label">Pajak</td>
                <td class="salary-info-value">Rp {{ number_format($pajak) }}</td>
            </tr>
        </table>
    </div>  

    <?php
        $BJHT = (int)$users->basic * (6.24/100);
        $Bkes = (int)$users->basic * (4/100);
        $totalbenefit = $BJHT + $Bkes;
    ?>

    <div class="divider2"></div>

    <!-- Benefit Information -->
    <div>
        <h4 class="section-header">Benefit</h4>
        <table>
            <tr>
                <td class="salary-info-label">BPJS Kesehatan</td>
                <td class="salary-info-value">Rp {{ number_format($BJHT) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJS Ketenagakerjaan</td>
                <td class="salary-info-value">Rp {{ number_format($Bkes) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Benefit</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($totalbenefit) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="summary-section">
        <table>
            <tr>
                <td class="section-header"><strong>Upah yang Diterima</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($total) }}</strong></td>
            </tr>
        </table>
    </div>
    <div class="footer">
        SDM RSPJ
    </div>
</body>
</html>
