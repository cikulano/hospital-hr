<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employee Salary Report</title>
    <style>
        @page { size: A4; margin: 1cm; }
        body { margin: 0; padding: 0 1cm; font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { 
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .header-cell {
            display: table-cell;
            vertical-align: middle;
        }
        .logo { 
            max-width: 120px;
            max-height: 60px;
            width: auto;
            height: auto;
        }
        .title { 
            text-align: center;
        }
        h3 { 
            color: #3498db; 
            margin: 0; 
            font-size: 24px; 
        }
    </style>
</head>
<body>
    <!-- Watermark -->
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; font-size: 200px; z-index: -1;">
        <img src="{{ $logo2Src }}" alt="Watermark">
    </div>

    <!-- Header -->
    <div class="header">
        <div class="header-cell" style="width: 25%;">
            <img src="{{ $logo1Src }}" alt="Company Logo 1" class="logo">
        </div>
        <div class="header-cell title" style="width: 50%;">
            <h3>Pay Slip</h3>
        </div>
        <div class="header-cell" style="width: 25%; text-align: right;">
            <img src="{{ $logo2Src }}" alt="Company Logo 2" class="logo">
        </div>
    </div>

    <div style="border-top: 2px solid #3498db; margin: 10px 0;"></div>
    <!-- Personal Information -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 15%;"><strong>Lokasi</strong></td>
            <td style="width: 35%;">: {{ $users->department }}</td>
            <td style="width: 25%; padding-left: 40px;"><strong>Nama Pekerja</strong></td>
            <td style="width: 35%;">: {{ $users->name }}</td>
        </tr>
        <tr>
            <td><strong>Bulan</strong></td>
            <td>: {{ \Carbon\Carbon::now()->subMonth()->locale('id')->isoFormat('MMMM YYYY') }}</td>
            <td style="padding-left: 40px;"><strong>Nopeg</strong></td>
            <td>: {{ $users->user_id }}</td>
        </tr>
    </table>

    <div style="border-top: 2px solid #3498db; margin: 10px 0;"></div>

    <!-- Salary Information -->
    <?php
        $lembur = (int)$users->da;
        $shift = (int)$users->hra;
        $keahlian = (int)$users->conveyance;
        $transport = (int)$users->allowance;
        $onsite = (int)$users->medical_allowance;
        $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite;

        $pajak = (int)$users->tds;
        $JHT = (int)$users->leave;
        $JP = (int)$users->prof_tax;
        $BPJSKes = (int)$users->pf;
        $proporsional = (int) $users->labour_welfare;
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
        if ($users->labour_welfare != 0) {
            $totalPotongan += $proporsional;
        }

        if ($users->department === "Pertamina Hulu Rokan") {
            $totalPotongan -= $JHT;
            $totalPotongan -= $JP;
            $totalPotongan -= $BPJSKes;
        }
        
        $total = $users->salary;
    ?>

    <!-- Pendapatan Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Pendapatan</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">THP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($users->basic) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Uang Lembur</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($lembur) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Tunjangan Shift</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($shift) }}</td>
            </tr>
            @if($users->department === "Kantor Pusat Pertamina")
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Transportasi</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($transport) }}</td>
            </tr>
            @endif
            @if($users->conveyance != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Tunjangan Keahlian</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($keahlian) }}</td>
            </tr>
            @endif
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Kompensasi Lain-lain</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($onsite) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;"><strong>Total Pendapatan</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;"><strong>{{ number_format($totalPendapatan) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="border-top: 3px solid #28a745; margin: 10px 0;"></div>

    <!-- Potongan Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 2px; font-size: 14px; color: #333; margin-bottom: 8px;">Potongan</h4>
        <table style="width: 100%; border-collapse: collapse;">
            @if($users->labour_welfare != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Proporsional</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($proporsional) }}</td>
            </tr>
            @endif
            
            @if($users->department != "Pertamina Hulu Rokan")
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJSTK JHT</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($JHT) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJSTK JP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($JP) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS Kesehatan</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($BPJSKes) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;"><strong>Total Potongan</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;"><strong>{{ number_format($totalPotongan) }}</strong></td>
            </tr>
            @else
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJSTK JHT</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJSTK JP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS Kesehatan</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format(0) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;"><strong>Total Potongan</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;"><strong>{{ number_format($proporsional) }}</strong></td>
            </tr>
            @endif
        </table>
    </div>

    <div style="border-top: 3px solid #28a745; margin: 5px 0;"></div>

    <!-- Pajak Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Pajak</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Pajak</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($pajak) }}</td>
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

    <div style="border-top: 3px solid #28a745; margin: 5px 0;"></div>

    <!-- Benefit Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Benefit</h4>
        <table style="width: 100%; border-collapse: collapse;">
            @if($users->department === "Pertamina Hulu Rokan")
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS JHT</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($BJHT) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS JP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($BJP) }}</td>
            </tr>
            @else
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS Ketenagakerjaan</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($BJHT) }}</td>
            </tr>
            @endif
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS Kesehatan</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($Bkes) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;"><strong>Total Benefit</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;"><strong>{{ number_format($totalbenefit) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 15px; border: 2px solid #3498db; padding: 10px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333;"><strong>Upah yang Diterima</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px;"><strong>{{ number_format($total) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
