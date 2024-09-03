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
                                    <!-- Slip Upah {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }} -->
                                </h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <!-- <h3 class="text-uppercase">Payslip #49029</h3> -->
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-sm-6">

                                @if(!empty($users->avatar))
                                    <img src="{{ $logo2Src }}" alt="Company Logo" style="max-width: 150px;">
                                @endif
                            </div>
                            <div class="col-sm-6 text-right">
                                <h5><strong>{{ $users->name }}</strong></h5>
                                <p>{{ $users->position }}<br>
                                NoPeg: {{ $users->user_id }}</p>
                            </div>
                        </div>

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

                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="mb-3"><strong>Pendapatan</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>THP</strong></td>
                                                <td class="text-right">Rp {{ number_format($users->basic) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Uang Lembur</strong></td>
                                                <td class="text-right">Rp {{ number_format($lembur) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan Shift</strong></td>
                                                <td class="text-right">Rp {{ number_format($shift) }}</td>
                                            </tr>
                                            @if($users->department === "Kantor Pusat Pertamina")
                                            <tr>
                                                <td><strong>Transportasi</strong></td>
                                                <td class="text-right">Rp {{ number_format($transport) }}</td>
                                            </tr>
                                            @endif
                                            @if($users->conveyance != 0)
                                            <tr>
                                                <td><strong>Tunjangan Keahlian</strong></td>
                                                <td class="text-right"> {{ number_format($keahlian) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Kompensasi Lain-lain</strong></td>
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
                                        @if($users->esi != 0)
                                        <tr>
                                        <td><strong>Proporsional</strong></td>
                                            <td class="text-right">{{ number_format($proporsional) }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($users->department != "Pertamina Hulu Rokan")
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
                                        <tr>
                                            <td><strong>Total Potongan</strong></td>
                                            <td class="text-right"><strong>Rp {{ number_format($totalPotongan) }}</strong></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td><strong>BPJSTK JHT</strong></td>
                                            <td class="text-right">Rp {{ number_format(0) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>BPJSTK JP</strong></td>
                                            <td class="text-right">Rp {{ number_format(0) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>BPJS Kesehatan</strong></td>
                                            <td class="text-right">Rp {{ number_format(0) }}</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>Total Potongan</strong></td>
                                            <td class="text-right"><strong>Rp {{ number_format($proporsional) }}</strong></td>
                                        </tr>
                                        @endif
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
        <a href="{{ secure_route('home') }}" class="btn btn-info mr-2">
            <i class="fas fa-home"></i> Home
        </a>
        <button id="generatePdf" class="btn btn-primary mr-2">
            <i class="fas fa-file-pdf"></i> Generate PDF
        </button>
        <button id="sendEmail" class="btn btn-success">
            <i class="fas fa-envelope"></i> Send to Email
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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