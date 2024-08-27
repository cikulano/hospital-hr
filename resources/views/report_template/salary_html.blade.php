<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        .payslip-title {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .net-salary {
            font-size: 1.2em;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container mt-5" id="report-content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h4 class="payslip-title">Slip Upah {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <!-- <h3 class="text-uppercase">Payslip #49029</h3> -->
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                @if(!empty($users->avatar))
                                    <img src="{{ $logoSrc }}" alt="Company Logo" style="max-width: 150px;">
                                @endif
                            </div>
                            <div class="col-sm-6 text-right">
                                <h5><strong>{{ $users->name }}</strong></h5>
                                <p>{{ $users->position }}<br>
                                NoPeg: {{ $users->user_id }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="mb-3"><strong>Pendapatan</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @php
                                                $lembur = (int)$users->da * (int)$users->conveyance;
                                                $shift = (int)$users->hra * (int)$users->allowance;
                                                $onsite = (int)$users->medical_allowance;
                                                $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite;
                                            @endphp
                                            <tr>
                                                <td><strong>THP</strong></td>
                                                <td class="text-right">Rp {{ number_format($users->basic) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kompensasi Lembur</strong></td>
                                                <td class="text-right">Rp {{ number_format($lembur) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kompensasi Shift</strong></td>
                                                <td class="text-right">Rp {{ number_format($shift) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kompensasi OnSite</strong></td>
                                                <td class="text-right">Rp {{ number_format($onsite) }}</td>
                                            </tr>
                                            <tr class="table-primary">
                                                <td><strong>Total Salary</strong></td>
                                                <td class="text-right"><strong>Rp {{ number_format($totalPendapatan) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="mb-3"><strong>Potongan</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @php
                                                $pajak = ((int)$users->tds) ;
                                                $JHT = (int)$users->basic * 0.02;
                                                $JP = (int)$users->basic * 0.01;
                                                $BPJSKes = (int)$users->basic * 0.01;
                                                $totalPotongan = $pajak + $JHT + $JP + $BPJSKes;
                                                $total = $totalPendapatan - $totalPotongan;
                                            @endphp
                                            <tr>
                                                <td><strong>Iuran Pajak {{ ($users->tds) }}</strong></td>
                                                <td class="text-right">Rp {{ number_format($pajak) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran JHT 2%</strong></td>
                                                <td class="text-right">Rp {{ number_format($JHT) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran JP 1%</strong></td>
                                                <td class="text-right">Rp {{ number_format($JP) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran BPJS Kesehatan 1%</strong></td>
                                                <td class="text-right">Rp {{ number_format($BPJSKes) }}</td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td><strong>Total Potongan</strong></td>
                                                <td class="text-right"><strong>Rp {{ number_format($totalPotongan) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12 text-right">
                                <p class="net-salary"><strong>Net Salary: Rp {{ number_format($total) }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <!-- <a href="{{ url('/') }}" class="btn btn-info mr-2">
            <i class="fas fa-home"></i> Home
        </a> -->
        <button id="generatePdf" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Generate PDF
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('generatePdf').addEventListener('click', function() {
            // Make an AJAX request to get the PDF HTML
            fetch('{{ route("salary.pdf.html", ["user_id" => $users->user_id]) }}')
                .then(response => response.text())
                .then(html => {
                    // Create a new div to hold the PDF HTML
                    var element = document.createElement('div');
                    element.innerHTML = html;
                    
                    var opt = {
                        margin:       1,
                        filename:     'Slip Upah {{ $users->name }}.pdf',
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2 },
                        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
                    };

                    html2pdf().set(opt).from(element).save();
                });
        });
    </script>
</body>
</html>