<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            text-align: right;
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
                                <h4 class="payslip-title">
                                    Slip Upah {{ \Carbon\Carbon::now()->subMonth()->locale('id')->isoFormat('MMMM YYYY') }}
                                </h4>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                @if(isset($logo2Src))
                                    <img src="{{ $logo2Src }}" alt="Company Logo" style="max-width: 150px;">
                                @endif
                            </div>
                            <div class="col-sm-6 text-right">
                                <h5><strong>{{ $users->name ?? 'N/A' }}</strong></h5>
                                <p>{{ $users->department_name ?? 'N/A' }}<br>
                                NoPeg: {{ $users->nopeg ?? 'N/A' }}</p>
                            </div>
                        </div>

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

                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="mb-3"><strong>Pendapatan</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                        @if($users->name != "Ripan Julhakim")
                                            <tr>
                                                <td><strong>THP</strong></td>
                                                <td class="text-right">Rp {{ number_format($users->thp ?? 0) }}</td>
                                            </tr>
                                        @endif
                                            <tr>
                                                <td><strong>Uang Lembur</strong></td>
                                                <td class="text-right">Rp {{ number_format($lembur) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan Shift</strong></td>
                                                <td class="text-right">Rp {{ number_format($shift) }}</td>
                                            </tr>
                                            @if(($users->department_name ?? '') === "Kantor Pusat Pertamina")
                                            <tr>
                                                <td><strong>Transportasi</strong></td>
                                                <td class="text-right">Rp {{ number_format($transport) }}</td>
                                            </tr>
                                            @if($proporsional != 0)
                                            <tr>
                                                <td><strong>Proporsional</strong></td>
                                                <td class="text-right">Rp {{ number_format($proporsional) }}</td>
                                                </tr>
                                                @endif
                                            @endif
                                            @if($keahlian != 0)
                                            <tr>
                                                <td><strong>Tunjangan Keahlian</strong></td>
                                                <td class="text-right">Rp {{ number_format($keahlian) }}</td>
                                            </tr>
                                            @endif
                                            @if($poli_sore_sabtu != 0)
                                            <tr>
                                                <td><strong>Poli Sore & Sabtu</strong></td>
                                                <td class="text-right">Rp {{ number_format($poli_sore_sabtu) }}</td>
                                            </tr>
                                            @endif
                                            @if($oncall != 0)
                                            <tr>
                                                <td><strong>Oncall</strong></td>
                                                <td class="text-right">Rp {{ number_format($oncall) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Kompensasi Lain-lain</strong></td>
                                                <td class="text-right">Rp {{ number_format($kompensasi) }}</td>
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
                                        <tr>
                                            <td><strong>Pajak</strong></td>
                                            <td class="text-right">Rp {{ number_format($pajak) }}</td>
                                        </tr>
                                        @if($users->department_name !== "Kantor Pusat Pertamina" and $users->name !== "Ripan Julhakim")
                                        @if($proporsional != 0)
                                        <tr>
                                            <td><strong>Proporsional</strong></td>
                                            <td class="text-right">Rp {{ number_format($proporsional) }}</td>
                                        </tr>
                                        @endif
                                        @endif
                                        <tr>
                                            <td><strong>BPJSTK JHT</strong></td>
                                            <td class="text-right">Rp {{ number_format($JHT) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>BPJSTK JP</strong></td>
                                            <td class="text-right">Rp {{ number_format($JP) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>BPJS Kesehatan</strong></td>
                                            <td class="text-right">Rp {{ number_format($BPJSKes) }}</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>Total Potongan</strong></td>
                                            <td class="text-right"><strong>Rp {{ number_format($totalPotongan) }}</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <p class="net-salary"><strong>Net Salary: Rp {{ number_format($salary) }}</strong></p>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-6 text-left">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ secure_route('home') }}" class="btn btn-info">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button id="generatePdf" class="btn btn-primary mr-2">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button id="sendEmail" class="btn btn-success">
                            <i class="fas fa-envelope"></i> Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('generatePdf').addEventListener('click', function() {
            @if($users)
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
            @else
            console.error('User data is not available.');
            @endif
        });

        document.getElementById('sendEmail').addEventListener('click', function() {
            Swal.fire({
                title: 'Sending Email...',
                text: 'Please wait while we send the email.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route("salary.send.email", ["user_id" => $users->user_id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Sent',
                        text: 'Salary slip has been sent to your email.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Send Email',
                        text: data.message
                    });
                }
            })
            .catch((error) => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'An Error Occurred',
                    text: error.message || 'Please try again.'
                });
            });
        });
    </script>
</body>

</html>