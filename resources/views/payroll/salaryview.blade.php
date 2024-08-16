
@extends('layouts.exportmaster')
@section('content')
    <!-- Page Wrapper -->
    <div class="">
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid" id="app">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col" style="margin-left: -222px;">
                        <h3 class="page-title">Payslip</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('form/salary/page') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payslip</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" style="color: green"><i class="fa fa-file-excel-o"></i><a href="{{ url("extra/report/excel/?user_id=$users->user_id") }}"> Excel</a></button>
                            <button class="btn btn-white" style="color: red"><i class="fa fa-file-pdf-o"></i> <a href="{{ url("extra/report/pdf/?user_id=$users->user_id") }}">PDF</a></button>
                            <button class="btn btn-white" style="color: black"><i class="fa fa-print fa-lg"></i><a href="" @click.prevent="printme" target="_blank"> Print</a></button>
                        </div>
                    </div>
                </div>
           
            <div class="row" style="margin-left: -240px;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="payslip-title">Payslip for the month of {{ \Carbon\Carbon::now()->format('M') }}   {{ \Carbon\Carbon::now()->year }}  </h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    @if(!empty($users->avatar))
                                    <img src="{{ URL::to('/assets/images/'. $users->avatar) }}" class="inv-logo" alt="{{ $users->name }}">
                                    @endif

                                    <!-- <ul class="list-unstyled mb-0">
                                        <li>{{ $users->name }}</li>
                                    </ul> -->
                                    
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Payslip #49029</h3>
                                        <ul class="list-unstyled">
                                            <li>Salary Month: <span>{{ \Carbon\Carbon::now()->format('M') }}  , {{ \Carbon\Carbon::now()->year }}  </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li><h5 class="mb-0"><strong>{{ $users->name }}</strong></h5></li>
                                        <li><span>{{ $users->position }}</span></li>
                                        <li>Employee ID: {{ $users->user_id }}</li>
                                        <!-- <li>Joining Date: {{ $users->join_date }}</li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <?php
                                                $lembur = (int)$users->da * (int)$users->conveyance;
                                                $shift = (int)$users->hra * (int)$users->allowance;
                                                $onsite = (int)$users->medical_allowance;
                                                $totalPendapatan = (int)$users->basic + $lembur + $shift + $onsite
                                            ?>
                                            <tr>
                                                <td><strong>THP
                                                <span class="float-right">Rp {{ number_format($users->basic) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan Lembur
                                                <span class="float-right">Rp {{ number_format($lembur) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan Shift
                                                <span class="float-right">Rp {{ number_format($shift) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan OnSite
                                                <span class="float-right">Rp {{ number_format($onsite) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Salary</strong>
                                                <span class="float-right"><strong>Rp {{ number_format($totalPendapatan) }}</strong></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Potongan</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <?php
                                                $pajak = ((int)$users->tds/100) * (int)$users->basic;
                                                $JHT = (int)$users->basic * 0.02;
                                                $JP = (int)$users->basic * 0.01;
                                                $BPJSKes = (int)$users->basic * 0.01;
                                                $totalPotongan = $pajak + $JHT + $JP + $BPJSKes;
                                                $total = $totalPendapatan - $totalPotongan
                                            ?>
                                            <tr>
                                                <td><strong>Iuran Pajak {{ ($users->tds) }} %
                                                <span class="float-right">Rp {{ number_format($pajak) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran JHT 2%
                                                <span class="float-right">Rp {{ number_format($JHT) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran JP 1%
                                                <span class="float-right">Rp {{ number_format($JP) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Iuran BPJS Kesehatan 1%
                                                <span class="float-right">Rp {{ number_format($BPJSKes) }}</span></td></strong>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Potongan</strong>
                                                <span class="float-right"><strong>Rp {{ number_format($totalPotongan) }}</strong></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12" >
                                    <p><strong>Net Salary: Rp {{ number_format($total) }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->
    </div>
@endsection
