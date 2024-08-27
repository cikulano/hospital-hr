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
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            position: relative;
        }
        .header {
            margin-bottom: 20px;
        }
        .logo {
            width: 100%;
            max-width: 150px;
            height: auto;
        }
        .company-info {
            flex: 1;
            text-align: center;
        }
        .company-info h2 {
            color: #006400;
            margin: 0;
            font-size: 16px;
        }
        .divider {
            border-top: 1px solid #006400;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 5px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .section-header {
            background-color: #e0f0e0;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px;
            font-size: 16px;
        }
        .amount {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
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
        .personal-title {
        font-weight: bold;
        padding-right: 10px; 
        width: 20%;
        }
        .personal-value {
            width: 30%;
        }
        .salary-info-label {
            width: 50%;
            text-align: left;
        }
        .salary-info-value {
            width: 50%;
            text-align: right;
        }
        .alternate-row {
        background-color: #f9f9f9;
    }
    </style>
</head>
<body>
    <div class="watermark">
        <img src="{{ $logoSrc }}" alt="Watermark">
    </div>
    <div class="header">
        <table width="100%">
            <tr>
                <td width="30%" style="vertical-align: middle;">
                    <img src="{{ $logoSrc }}" alt="Company Logo" class="logo">
                </td>
                <td width="80%" style="vertical-align: middle;">
                    <div class="company-info">
                        <h2>PT. PERTAMINA BINA MEDIKA</h2>
                        <h2>(P E R T A M E D I K A)</h2>
                        <h2>S L I P  U P A H</h2>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <!-- Personal Information -->
    <table>
    <tr>
        <td class="personal-title">Nopeg</td>
        <td>: {{ $users->user_id }}</td>
        <td class="personal-title">Nama Pekerja</td>
        <td>: {{ $users->name }}</td>
    </tr>
    <tr>
        <td class="personal-title">Fungsi</td>
        <td>: {{ $users->position }}</td>
        <td class="personal-title">Unit</td>
        <td>: {{ $users->department }}</td>
    </tr>
    <tr>
        <td class="personal-title">Periode Slip Upah</td>
        <td colspan="3">: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</td>
    </tr>
</table>

    <div class="divider"></div>

     <!-- Salary Information -->
    <?php
        $lembur = (int)$users->da * (int)$users->conveyance;
        $shift = (int)$users->hra * (int)$users->allowance;
        $onsite = (int)$users->medical_allowance;
        $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite
    ?>

    <div class="salary-info">
        <h4 class="section-header">Informasi Pendapatan</h4>
        <table>
            <tr>
                <td class="salary-info-label">THP</td>
                <td class="salary-info-value">Rp {{ number_format($users->basic) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Kompensasi Lembur</td>
                <td class="salary-info-value">Rp {{ number_format($lembur) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Kompensasi Shift</td>
                <td class="salary-info-value">Rp {{ number_format($shift) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Kompensasi OnSite</td>
                <td class="salary-info-value">Rp {{ number_format($onsite) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Salary</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($totalPendapatan) }}</strong></td>
            </tr>
        </table>
    </div>

    <?php
        $pajak = (int)$users->tds;
        $JHT = (int)$users->basic * 0.02;
        $JP = (int)$users->basic * 0.01;
        $BPJSKes = (int)$users->basic * 0.01;
        $totalPotongan = $pajak + $JHT + $JP + $BPJSKes;
        $total = $totalPendapatan - $totalPotongan
    ?>

    <!-- Potongan Information -->
    <div class="salary-info">
        <h4 class="section-header">Informasi Potongan</h4>
        <table>
            <tr>
                <td class="salary-info-label"> Iuran Pajak {{ ($users->tds) }} </td>
                <td class="salary-info-value">Rp {{ number_format($pajak) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Iuran JHT 2%</td>
                <td class="salary-info-value">Rp {{ number_format($JHT) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Iuran JP 1%</td>
                <td class="salary-info-value">Rp {{ number_format($JP) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label">Iuran BPJS Kesehatan 1%</td>
                <td class="salary-info-value">Rp {{ number_format($BPJSKes) }}</td>
            </tr>
            <tr>
                <td class="salary-info-label"><strong>Total Potongan</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($totalPotongan) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="section-header">
        <table>
            <tr>
                <td class="salary-info-label"><strong>Total Pendapatan</strong></td>
                <td class="salary-info-value"><strong>Rp {{ number_format($total) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        SDM RSPJ
    </div>
</body>
</html>