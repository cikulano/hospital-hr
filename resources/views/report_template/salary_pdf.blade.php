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
            <td style="width: 10%;"><strong>Lokasi</strong></td>
            <td style="width: 35%;">: {{ $users->department_name }}</td>
            <td style="width: 25%; padding-left: 40px;"><strong>Nama Pekerja</strong></td>
            <td style="width: 35%;">: {{ $users->name }}</td>
        </tr>
        <tr>
            <td><strong>Bulan</strong></td>
            <td>: {{ \Carbon\Carbon::now()->subMonth()->locale('id')->isoFormat('MMMM YYYY') }}</td>
            <td style="padding-left: 40px;"><strong>Nopeg</strong></td>
            <td>: {{ $users->nopeg }}</td>
        </tr>
    </table>

    <div style="border-top: 2px solid #3498db; margin: 10px 0;"></div>

    <!-- Salary Information -->
    @php
        $salary = $users->salary ?? 0;
        $thp = $users->thp ?? 0;
        $lembur = $users->lembur ?? 0;
        $shift = $users->shift ?? 0;
        $keahlian = $users->tunjangan_keahlian ?? 0;
        $transport = $users->transport ?? 0;
        $kompensasi = $users->kompensasi ?? 0;
        $poli_sore_sabtu = $users->poli_sore_sabtu ?? 0;
        $oncall = $users->oncall ?? 0;
        $totalPendapatan = $thp + $lembur + $shift + $kompensasi + $transport + $keahlian + $poli_sore_sabtu + $oncall;

        if($users->name == "Ripan Julhakim"){
            $totalPendapatan = $totalPendapatan - $thp;
        }

        $pajak = $users->pajak ?? 0;
        $proporsional = $users->proporsional ?? 0;
        $JHT = $users->potongan_jht ?? 0;
        $JP = $users->potongan_jp ?? 0;
        $BPJSKes = $users->potongan_bpjskes ?? 0;
        $totalPotongan = $JHT + $JP + $BPJSKes;

        if($users->department_name == "Kantor Pusat Pertamina"){
            $totalPendapatan = $totalPendapatan + $proporsional;
        }

        $benefit_bpjskes = $users->benefit_bpjskes ?? 0;
        $benefit_jp = $users->benefit_jp ?? 0;
        $benefit_jht = $users->benefit_jht ?? 0;
        $totalBenefit = $benefit_bpjskes + $benefit_jp + $benefit_jht;                  
    @endphp

    <!-- Pendapatan Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Pendapatan</h4>
        <table style="width: 100%; border-collapse: collapse;">
            @if($users->name != "Ripan Julhakim")
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">THP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($thp) }}</td>
            </tr>
            @endif
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Uang Lembur</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($lembur) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Tunjangan Shift</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($shift) }}</td>
            </tr>
            @if($users->department_name === "Kantor Pusat Pertamina")
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Transportasi</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($transport) }}</td>
            </tr>
            @if($proporsional != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Proporsional</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($proporsional) }}</td>
            </tr>
            @endif
            @endif
            @if($keahlian != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Tunjangan Keahlian</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($keahlian) }}</td>
            </tr>
            @endif
            @if($poli_sore_sabtu != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Poli Sore & Sabtu</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($poli_sore_sabtu) }}</td>
            </tr>
            @endif
            @if($oncall != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Oncall</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($oncall) }}</td>
            </tr>
            @endif
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Kompensasi Lain-lain</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($kompensasi) }}</td>
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
        @if($users->department_name !== "Kantor Pusat Pertamina" and $users->name !== "Ripan Julhakim")
            @if($proporsional != 0)
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">Proporsional</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($proporsional) }}</td>
            </tr>
            @endif
        @endif
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

    <div style="border-top: 3px solid #28a745; margin: 5px 0;"></div>

    <!-- Benefit Information -->
    <div>
        <h4 style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333; margin-bottom: 8px;">Benefit</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS JHT</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($benefit_jht) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS JP</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($benefit_jp) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;">BPJS Kesehatan</td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;">{{ number_format($benefit_bpjskes) }}</td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; padding: 4px; border-bottom: 1px solid #ddd;"><strong>Total Benefit</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px; border-bottom: 1px solid #ddd;"><strong>{{ number_format($totalBenefit) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 15px; border: 2px solid #3498db; padding: 10px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; text-transform: uppercase; padding: 5px; font-size: 14px; color: #333;"><strong>Upah yang Diterima</strong></td>
                <td style="width: 30%; text-align: right; padding: 4px;"><strong>{{ number_format($salary) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
