<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employee Salary Report</title>
    <style>
        @page { size: A4; margin: 0; }
    </style>
</head>
<body style="margin: 1.5cm; font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #333; position: relative;">
    <!-- Watermark and Logo -->
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; font-size: 200px; z-index: -1;">
        <img src="{{ $logo2Src }}" alt="Watermark">
    </div>
    <div style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; position: relative;">
        <img src="{{ $logo1Src }}" alt="Company Logo 1" style="max-width: 160px; max-height: 80px; width: auto; height: auto; object-fit: contain; position: absolute; top: 0; left: 0;">
        <div style="text-align: center; flex-grow: 1;">
            <h3 style="color: #3498db; margin: 0; font-size: 30px;">Pay Slip</h3>
        </div>
        <img src="{{ $logo2Src }}" alt="Company Logo 2" style="max-width: 120px; max-height: 50px; width: auto; height: auto; object-fit: contain; position: absolute; top: 0; right: 0;">
    </div>

    <div style="border-top: 2px solid #3498db; margin: 10px 0;"></div>
    <!-- Personal Information -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 15%;"><strong>Lokasi</strong></td>
            <td style="width: 35%;">: {{ $users->department }}</td>
            <td style="width: 20%; padding-left: 40px;"><strong>Nama Pekerja</strong></td>
            <td style="width: 35%;">: {{ $users->name }}</td>
        </tr>
        <tr>
            <td><strong>Bulan</strong></td>
            <td>: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</td>
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
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Potongan</h4>
        <table style="width: 100%; border-collapse: collapse;">
            @if($users->esi != 0)
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

    <div style="border-top: 3px solid #28a745; margin: 10px 0;"></div>

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

    <div style="border-top: 3px solid #28a745; margin: 10px 0;"></div>

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
