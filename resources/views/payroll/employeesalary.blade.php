@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee Salary <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ secure_route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($departments as $department)
                                    @if($department !== null)
                                        <a class="dropdown-item bulk-download" href="{{ route('payroll.bulk.download.pdf', ['department' => urlencode($department)]) }}" data-department="{{ $department }}">{{ $department }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <a href="#" class="btn custom-blue" data-toggle="modal" data-target="#add_salary">
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-excel-o"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ secure_route('salary.format.download') }}" class="dropdown-item">
                                    <i class="fa fa-download"></i> Download Format
                                </a>
                                <form action="{{ secure_route('salary.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="file" class="dropdown-item mb-0" style="cursor: pointer;">
                                        <i class="fa fa-upload"></i> Choose File
                                        <input type="file" name="file" id="file" class="d-none">
                                    </label>
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa fa-file-excel-o"></i> Import Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                     

            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <input type="text" id="employeeSearch" class="form-control floating" autocomplete="off">
                        <label class="focus-label">Search Employee</label>
                        <ul id="employeeList" class="dropdown-menu" style="display:none;"></ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="departmentFilter"> 
                            <option value=""> -- Select Department -- </option>
                            @foreach($departments as $id => $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Department</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <a href="#" class="btn btn-success btn-block" id="searchBtn"> Search </a>  
                </div>     
            </div>
            <!-- /Search Filter --> 
             
            <!-- /Page Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Employee</th>
                                    <th >NoPeg</th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th >Email</th>
                                    <th >Department</th>
                                    <th >Salary</th>
                                    <th hidden></th>
                                    <th class="text-center">Payslip</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $items)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ secure_asset('employee/profile/'.$items->user_id) }}" class="avatar">
                                                <img alt="" src="{{ asset_url('/assets/images/'. $items->avatar) }}">
                                            </a>
                                            <a href="{{ url('employee/profile/'.$items->user_id) }}">{{ $items->name }}<span>{{ $items->position_name }}</span></a>
                                        </h2>
                                    </td>
                                    <td >{{ $items->user_id }}</td>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td hidden class="name">{{ $items->name }}</td>
                                    <td hidden class="salary">{{ $items->salary }}</td>
                                    <td hidden class="thp">{{ $items->thp }}</td>
                                    <td hidden class="lembur">{{ $items->lembur }}</td>
                                    <td hidden class="shift">{{ $items->shift }}</td>
                                    <td hidden class="tunjangan_keahlian">{{ $items->tunjangan_keahlian }}</td>
                                    <td hidden class="transport">{{ $items->transport }}</td>
                                    <td hidden class="kompensasi">{{ $items->kompensasi }}</td>
                                    <td hidden class="pajak">{{ $items->pajak }}</td>
                                    <td hidden class="potongan_bpjskes">{{ $items->potongan_bpjskes }}</td>
                                    <td hidden class="potongan_jp">{{ $items->potongan_jp }}</td>
                                    <td hidden class="potongan_jht">{{ $items->potongan_jht }}</td>
                                    <td hidden class="benefit_bpjskes">{{ $items->benefit_bpjskes }}</td>
                                    <td hidden class="benefit_jp">{{ $items->benefit_jp }}</td>
                                    <td hidden class="benefit_jht">{{ $items->benefit_jht }}</td>
                                    <td >{{ $items->email }}</td>
                                    <td >{{ $items->department_name }}</td>
                                    <td >Rp {{ number_format($items->salary, 0, ',', '.') }}</td>
                                    <td hidden class="salary">{{ $items->salary }}</td>

                                    <td class="text-center">
                                        <a class="btn btn-sm btn-success" href="{{ route('extra.report.html', ['user_id' => $items->user_id]) }}" target="_blank">Generate Slip</a>
                                    </td>

                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a class="userSalary btn-edit" href="#" data-toggle="modal" data-target="#edit_salary">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <a class="salaryDelete btn-delete" href="#" data-toggle="modal" data-target="#delete_salary">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Salary Modal -->
        <div id="add_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Upah Pekerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ secure_route('form/salary/save') }}" method="POST">
                            @csrf
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Pilih Pekerja</label>
                                        <select class="select select2s-hidden-accessible @error('user_id') is-invalid @enderror custom-select" tabindex="-1" aria-hidden="true" id="user_id" name="user_id">
                                            <option value="">-- Select --</option>
                                            @foreach ($userList as $key=>$user )
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <h4 class="text-primary">Earnings</h4>
                                    
                                    <div class="form-group">
                                        <label>Salary</label>
                                        <input class="form-control" type="text" name="salary" id="salary" value="{{ old('salary') }}" placeholder="Enter Salary" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>THP</label>
                                        <input class="form-control" type="text" name="thp" id="thp" value="{{ old('thp') }}" placeholder="Enter THP" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Lembur</label>
                                        <input class="form-control" type="text" name="lembur" id="lembur" value="{{ old('lembur') }}" placeholder="Enter Lembur" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <input class="form-control" type="text" name="shift" id="shift" value="{{ old('shift') }}" placeholder="Enter Shift" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Tunjangan Keahlian</label>
                                        <input class="form-control" type="text" name="tunjangan_keahlian" id="tunjangan_keahlian" value="{{ old('tunjangan_keahlian') }}" placeholder="Enter Tunjangan Keahlian" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Transport</label>
                                        <input class="form-control" type="text" name="transport" id="transport" value="{{ old('transport') }}" placeholder="Enter Transport" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Kompensasi</label>
                                        <input class="form-control" type="text" name="kompensasi" id="kompensasi" value="{{ old('kompensasi') }}" placeholder="Enter Kompensasi" data-type="currency">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>Pajak</label>
                                        <input class="form-control" type="text" name="pajak" id="pajak" value="{{ old('pajak') }}" placeholder="Enter Pajak" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan BPJS Kesehatan</label>
                                        <input class="form-control" type="text" name="potongan_bpjskes" id="potongan_bpjskes" value="{{ old('potongan_bpjskes') }}" placeholder="Enter Potongan BPJS Kesehatan" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan JP</label>
                                        <input class="form-control" type="text" name="potongan_jp" id="potongan_jp" value="{{ old('potongan_jp') }}" placeholder="Enter Potongan JP" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan JHT</label>
                                        <input class="form-control" type="text" name="potongan_jht" id="potongan_jht" value="{{ old('potongan_jht') }}" placeholder="Enter Potongan JHT" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit BPJS Kesehatan</label>
                                        <input class="form-control" type="text" name="benefit_bpjskes" id="benefit_bpjskes" value="{{ old('benefit_bpjskes') }}" placeholder="Enter Benefit BPJS Kesehatan" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit JP</label>
                                        <input class="form-control" type="text" name="benefit_jp" id="benefit_jp" value="{{ old('benefit_jp') }}" placeholder="Enter Benefit JP" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit JHT</label>
                                        <input class="form-control" type="text" name="benefit_jht" id="benefit_jht" value="{{ old('benefit_jht') }}" placeholder="Enter Benefit JHT" data-type="currency">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Salary Modal -->
        
        <!-- Edit Salary Modal -->
        <div id="edit_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Staff Salary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ secure_route('form/salary/update') }}" method="POST">
                            @csrf
                            <input class="form-control" type="hidden" name="id" id="e_id" value="" readonly>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Name Staff</label>
                                        <input class="form-control" type="text" name="name" id="e_name" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Salary</label>
                                        <input class="form-control" type="text" name="salary" id="e_salary" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>THP</label>
                                        <input class="form-control" type="text" name="thp" id="e_thp" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Lembur</label>
                                        <input class="form-control" type="text" name="lembur" id="e_lembur" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <input class="form-control" type="text" name="shift" id="e_shift" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Tunjangan Keahlian</label>
                                        <input class="form-control" type="text" name="tunjangan_keahlian" id="e_tunjangan_keahlian" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Transport</label>
                                        <input class="form-control" type="text" name="transport" id="e_transport" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Kompensasi</label>
                                        <input class="form-control" type="text" name="kompensasi" id="e_kompensasi" value="" data-type="currency">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>Pajak</label>
                                        <input class="form-control" type="text" name="pajak" id="e_pajak" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan BPJS Kesehatan</label>
                                        <input class="form-control" type="text" name="potongan_bpjskes" id="e_potongan_bpjskes" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan JP</label>
                                        <input class="form-control" type="text" name="potongan_jp" id="e_potongan_jp" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Potongan JHT</label>
                                        <input class="form-control" type="text" name="potongan_jht" id="e_potongan_jht" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit BPJS Kesehatan</label>
                                        <input class="form-control" type="text" name="benefit_bpjskes" id="e_benefit_bpjskes" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit JP</label>
                                        <input class="form-control" type="text" name="benefit_jp" id="e_benefit_jp" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Benefit JHT</label>
                                        <input class="form-control" type="text" name="benefit_jht" id="e_benefit_jht" value="" data-type="currency">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Salary Modal -->

        <!-- Delete Salary Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Salary</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ secure_route('form/salary/delete') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" name="id" class="e_id" value="">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     <!-- Add this at the end of the file, just before the closing </div> tag of "page-wrapper" -->
        <div id="downloadModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="downloadSpinner" class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <h5 class="mt-3">Downloading PDFs for <span id="departmentName"></span>...</h5>
                    <p class="text-muted">This may take a few moments.</p>
                </div>
            </div>
            </div>
        </div>
        <!-- /Delete Salary Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wrap all existing JavaScript code here
            
            // Select2 initialization
            $('.select2s-hidden-accessible').select2({
                closeOnSelect: false
            });

            // Employee ID and email auto-select
            $('#name').on('change', function() {
                $('#employee_id').val($(this).find(':selected').data('employee_id'));
            });

            // Update salary
            $(document).on('click', '.userSalary', function() {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.id').text());
                $('#e_name').val(_this.find('.name').text());
                $('#e_salary').val(_this.find('.salary').text());
                $('#e_thp').val(_this.find('.thp').text());
                $('#e_lembur').val(_this.find('.lembur').text());
                $('#e_shift').val(_this.find('.shift').text());
                $('#e_tunjangan_keahlian').val(_this.find('.tunjangan_keahlian').text());
                $('#e_transport').val(_this.find('.transport').text());
                $('#e_kompensasi').val(_this.find('.kompensasi').text());
                $('#e_pajak').val(_this.find('.pajak').text());
                $('#e_potongan_bpjskes').val(_this.find('.potongan_bpjskes').text());
                $('#e_potongan_jp').val(_this.find('.potongan_jp').text());
                $('#e_potongan_jht').val(_this.find('.potongan_jht').text());
                $('#e_benefit_bpjskes').val(_this.find('.benefit_bpjskes').text());
                $('#e_benefit_jp').val(_this.find('.benefit_jp').text());
                $('#e_benefit_jht').val(_this.find('.benefit_jht').text());
            });

            // Delete salary
            $(document).on('click', '.salaryDelete', function() {
                var _this = $(this).parents('tr');
                $('.e_id').val(_this.find('.id').text());
            });

            // Currency formatting
            var currencyInputs = document.querySelectorAll('input[data-type="currency"]');
            currencyInputs.forEach(function(input) {
                input.addEventListener('keyup', function() {
                    formatCurrency(this);
                });

                input.addEventListener('blur', function() {
                    formatCurrency(this, 'blur');
                });
            });

            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function formatCurrency(input, blur) {
                var input_val = input.value;

                if (input_val === "") { return; }

                var original_len = input_val.length;
                var caret_pos = input.selectionStart;

                if (input_val.indexOf(".") >= 0) {
                    var decimal_pos = input_val.indexOf(".");
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    left_side = formatNumber(left_side);
                    right_side = formatNumber(right_side);

                    if (blur === "blur") {
                        right_side += "00";
                    }

                    right_side = right_side.substring(0, 2);
                    input_val = "Rp " + left_side + "." + right_side;

                } else {
                    input_val = formatNumber(input_val);
                    input_val = "Rp " + input_val;

                    if (blur === "blur") {
                        input_val += "";
                    }
                }

                input.value = input_val;

                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input.setSelectionRange(caret_pos, caret_pos);
            }

            // DataTable initialization and search functionality
            $(document).ready(function() {
                // Check if DataTable already exists
                if ($.fn.DataTable.isDataTable('table.datatable')) {
                    // Destroy existing DataTable
                    $('table.datatable').DataTable().destroy();
                }

                // Initialize DataTable
                var table = $('table.datatable').DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                });

                $('#employeeSearch').on('input', function() {
                    var searchTerm = $(this).val().toLowerCase().trim();
                    
                    if (searchTerm === '') {
                        // If search box is empty, reset the table to show all data
                        table.search('').columns().search('').draw();
                    } else {
                        // Otherwise, perform the search
                        table.search(searchTerm).draw();
                    }

                    updateAutocomplete(searchTerm);
                });

                // Custom filtering function
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var searchTerm = $('#employeeSearch').val().toLowerCase().trim();
                    
                    // If search term is empty, show all rows
                    if (searchTerm === '') {
                        return true;
                    }

                    var name = $(data[0]).text().toLowerCase(); // Extracting text from HTML content
                    var noPeg = data[1].toLowerCase();
                    var email = data[2].toLowerCase();
                    var department = data[3].toLowerCase();

                    return name.indexOf(searchTerm) > -1 || 
                        noPeg.indexOf(searchTerm) > -1 ||
                        email.indexOf(searchTerm) > -1 ||
                        department.indexOf(searchTerm) > -1;
                });

                // Autocomplete functionality
                var $list = $('#employeeList');

                function updateAutocomplete(input) {
                    var results = [];

                    table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                        var data = this.data();
                        var name = $(data[0]).text().toLowerCase();
                        var noPeg = data[1].toLowerCase();
                        var email = data[2].toLowerCase();
                        var department = data[3].toLowerCase();

                        if (name.indexOf(input) > -1 || 
                            noPeg.indexOf(input) > -1 ||
                            email.indexOf(input) > -1 ||
                            department.indexOf(input) > -1) {
                            results.push({ name: name, noPeg: noPeg, rowIdx: rowIdx });
                        }
                    });

                    $list.empty();

                    if (results.length > 0 && input.length > 0) {
                        $.each(results, function(i, result) {
                            $('<li>', {
                                html: result.name + ' <span class="text-muted">(' + result.noPeg + ')</span>',
                                click: function() {
                                    $('#employeeSearch').val(result.name.trim());
                                    $list.hide();
                                    table.search(result.name.trim()).draw();
                                }
                            }).appendTo($list);
                        });
                        $list.show();
                    } else {
                        $list.hide();
                    }
                }

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.form-group').length) {
                        $list.hide();
                        }
                    });
                });

            // File input change event
            var fileInput = document.getElementById('file');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    let fileName = this.files[0].name;
                    this.nextElementSibling.textContent = fileName;
                });
            }

            // Bulk download functionality
            $(document).ready(function() {
                $('.bulk-download').on('click', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var department = $(this).data('department');
                    
                    // Show the modal with spinner
                    $('#departmentName').text(department);
                    $('#downloadModal').modal('show');

                    // Start the download
                    $.ajax({
                        url: url,
                        method: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(data, status, xhr) {
                            var filename = "";
                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                            }

                            var blob = new Blob([data], { type: xhr.getResponseHeader('Content-Type') });
                            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                window.navigator.msSaveBlob(blob, filename);
                            } else {
                                var URL = window.URL || window.webkitURL;
                                var downloadUrl = URL.createObjectURL(blob);

                                if (filename) {
                                    // use HTML5 a[download] attribute to specify filename
                                    var a = document.createElement("a");
                                    // safari doesn't support this yet
                                    if (typeof a.download === 'undefined') {
                                        window.location = downloadUrl;
                                    } else {
                                        a.href = downloadUrl;
                                        a.download = filename;
                                        document.body.appendChild(a);
                                        a.click();
                                    }
                                } else {
                                    window.location = downloadUrl;
                                }

                                setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100); // cleanup
                            }

                            // Hide spinner, show success message
                            $('#downloadSpinner').hide();
                            $('.modal-body').html('<i class="fa fa-check-circle text-success fa-3x"></i><h5 class="mt-3">Download Complete!</h5>');
                            
                            // Close modal after 2 seconds
                            setTimeout(function() {
                                $('#downloadModal').modal('hide');
                                // Reset modal content
                                $('.modal-body').html('<div id="downloadSpinner" class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><h5 class="mt-3">Downloading PDFs for <span id="departmentName"></span>...</h5><p class="text-muted">This may take a few moments.</p>');
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            $('#downloadSpinner').hide();
                            $('.modal-body').html('<i class="fa fa-times-circle text-danger fa-3x"></i><h5 class="mt-3">Download Failed</h5><p>Error: ' + error + '</p>');
                            }
                        });
                    });
                });
            });
        </script>


    @endsection
@endsection
