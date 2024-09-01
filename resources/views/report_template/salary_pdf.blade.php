<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employee Salary Report</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 1cm;
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
            position: relative;
        }
        .logo {
            max-width: 120px;
            max-height: 60px;
            width: auto;
            height: auto;
            object-fit: contain;
            position: absolute;
            top: 0;
        }
        .logo1 {
            max-width: 160px;
            max-height: 80px;
            left: 0;
        }
        .logo2 {
            right: 0;
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
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 100px;
            z-index: -1;
        }
        .personal-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .personal-info-item {
            display: flex;
            align-items: baseline;
        }
        .personal-title {
            font-weight: bold;
            min-width: 100px;
            text-align: left;
            padding-right: 5px;
        }
        .personal-value {
            flex: 1;
            text-align: left;
        }
        .personal-value::before {
            content: ': ';
            margin-right: 3px;
        }
        .right-aligned {
            grid-column: 2;
            text-align: right;
        }
        .name-id-group {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
        .name-id-item {
            width: 50%;
            padding-left: 10px;
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
            <h3>Pay Slip</h3>
        </div>
        <img src="{{ $logo2Src }}" alt="Company Logo 2" class="logo logo2">
    </div>

    <div class="divider"></div>

    <!-- Personal Information -->
    <div class="personal-info">
        <div class="personal-info-item">
            <span class="personal-title">Lokasi</span>
            <span class="personal-value">{{ $users->department }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Nama Pekerja</span>
            <span class="personal-value">{{ $users->name }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Bulan</span>
            <span class="personal-value">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</span>
        </div>
        <div class="personal-info-item">
            <span class="personal-title">Nopeg</span>
            <span class="personal-value">{{ $users->user_id }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Salary Information -->
    <?php
        $lembur = (int)$users->da;
        $shift = (int)$users->hra;
        $keahlian = (int)$users->conveyance;
        $transport = (int)$users->allowance;
        $onsite = (int)$users->medical_allowance;
        $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite;

        $pajak = (int)$users->tds;
        $JHT = (int)$users->basic * 0.02;
        $JP = (int)$users->basic * 0.01;
        $BPJSKes = (int)$users->pf;
        $proporsional = (int) $users->esi;
        $totalPotongan = $JHT + $JP + $BPJSKes ;
        
        // Only add transport to total if department is "Kantor Pusat Pertamina"
        if ($users->department === "Kantor Pusat Pertamina") {
            $totalPendapatan += $transport;
        }

        // Only add if there are Tunjangan Keahlian
        if ($users->conveyance != 0) {
            $totalPendapatan += $keahlian;
        }

        // Only add to total if proportional is not 0
        if ($users->esi != 0) {
            $totalPotongan += $proporsional;
        }

        if ($users->department === "Pertamina Hulu Rokan") {
            $totalPotongan -= $JHT;
            $totalPotongan -= $JP;
            $totalPotongan -= $BPJSKes;
        }
        
        $total = $totalPendapatan - $totalPotongan;
    ?>

    <!-- Pendapatan Information -->
    <div>
        <h4 class="section-header">Pendapatan</h4>
        <table>
            <tr>
                <td class="salary-info-label">THP</td>
                <td class="salary-info-value">{{ number_format($users->basic) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Uang Lembur</td>
                <td class="salary-info-value">{{ number_format($lembur) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Tunjangan Shift</td>
                <td class="salary-info-value">{{ number_format($shift) }}</td>
            </tr>
            @if($users->department === "Kantor Pusat Pertamina")
            <tr>
                <td class="salary-info-label">Transportasi</td>
                <td class="salary-info-value"> {{ number_format($transport) }}</td>
            </tr>
            @endif
            @if($users->conveyance != 0)
            <tr>
                <td class="salary-info-label">Tunjangan Keahlian</td>
                <td class="salary-info-value"> {{ number_format($keahlian) }}</td>
            </tr>
            @endif
            <tr>
                <td class="salary-info-label">Kompensasi Lain-lain</td>
                <td class="salary-info-value"> {{ number_format($onsite) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Pendapatan</strong></td>
                <td class="salary-info-value"><strong> {{ number_format($totalPendapatan) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="divider2"></div>

    <!-- Potongan Information -->
    <div>
        <h4 class="section-header">Potongan</h4>
        <table>
            @if($users->esi != 0)
            <tr>
                <td class="salary-info-label">Proporsional</td>
                <td class="salary-info-value">{{ number_format($proporsional) }}</td>
            </tr>
            @endif
            
            @if($users->department != "Pertamina Hulu Rokan")
            <tr>
                <td class="salary-info-label">BPJSTK JHT</td>
                <td class="salary-info-value">{{ number_format($JHT) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJSTK JP</td>
                <td class="salary-info-value">{{ number_format($JP) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJS Kesehatan</td>
                <td class="salary-info-value">{{ number_format($BPJSKes) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Potongan</strong></td>
                <td class="salary-info-value"><strong>{{ number_format($totalPotongan) }}</strong></td>
            </tr>
            @else
            <tr>
                <td class="salary-info-label">BPJSTK JHT</td>
                <td class="salary-info-value">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJSTK JP</td>
                <td class="salary-info-value">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJS Kesehatan</td>
                <td class="salary-info-value">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Potongan</strong></td>
                <td class="salary-info-value"><strong>{{ number_format($proporsional) }}</strong></td>
            </tr>
            @endif
        </table>
    </div>

    <div class="divider2"></div>

    <!-- Pajak Information -->
    <div>
        <h4 class="section-header">Pajak</h4>
        <table>
            <tr>
                <td class="salary-info-label">Pajak</td>
                <td class="salary-info-value"> {{ number_format($pajak) }}</td>
            </tr>
        </table>
    </div>  

    <?php
        $BJHT = (int)$users->basic * (6.24 / 100);
        $Bkes = (int)$users->basic * (4 / 100);
        $totalbenefit = $BJHT + $Bkes;
        $BJP = 0; // Initialize BJP to prevent undefined variable error

        if ($users->department === "Pertamina Hulu Rokan") {
            $BJHT = (int)$users->basic * (5.7 / 100);
            $BJP = (int)$users->basic * (3 / 100);
            $Bkes = (int)$users->basic * (5 / 100);
            $totalbenefit = $BJHT + $Bkes + $BJP;
        } else {
            $BJHT = (int)$users->basic * (6.24 / 100);
            $Bkes = (int)$users->basic * (4 / 100);
            $totalbenefit = $BJHT + $Bkes;
        }
    ?>

    <div class="divider2"></div>

    <!-- Benefit Information -->
    <div>
        <h4 class="section-header">Benefit</h4>
        <table>
            @if($users->department === "Pertamina Hulu Rokan")
            <tr>
                <td class="salary-info-label">BPJS JHT</td>
                <td class="salary-info-value"> {{ number_format($BJHT) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">BPJS JP</td>
                <td class="salary-info-value"> {{ number_format($BJP) }}</td>
            </tr>
            @else
            <tr>
                <td class="salary-info-label">BPJS Ketenagakerjaan</td>
                <td class="salary-info-value"> {{ number_format($BJHT) }}</td>
            </tr>
            @endif
            <tr>
                <td class="salary-info-label">BPJS Kesehatan</td>
                <td class="salary-info-value"> {{ number_format($Bkes) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Benefit</strong></td>
                <td class="salary-info-value"><strong> {{ number_format($totalbenefit) }}</strong></td>
            </tr>
        </table>
    </div>


    <div class="summary-section">
        <table>
            <tr>
                <td class="section-header"><strong>Upah yang Diterima</strong></td>
                <td class="salary-info-value"><strong> {{ number_format($total) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
