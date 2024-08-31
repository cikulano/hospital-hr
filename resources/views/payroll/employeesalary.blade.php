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
                        <a href="#" class="btn custom-blue" data-toggle="modal" data-target="#add_salary">
                            <i class="fa fa-plus"></i> Add Salary
                        </a>
                        <a href="{{ secure_route('salary.format.download') }}" class="btn btn-info">
                            <i class="fa fa-download"></i> Download Format
                        </a>
                        <form action="{{ secure_route('salary.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                            @csrf
                            <input type="file" name="file" id="file" class="d-none">
                            <label for="file" class="btn btn-secondary mb-0">
                                <i class="fa fa-upload"></i> Choose File
                            </label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-file-excel-o"></i> Import Excel
                            </button>
                        </form>
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
                    <a href="#" class="btn btn-success btn-block"> Search </a>  
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
                                    <!-- <th>Role</th> -->
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
                                            <a href="{{ secure_asset('employee/profile/'.$items->user_id) }}" class="avatar"><img alt="" src="{{ asset_url('/assets/images/'. $items->avatar) }}"></a>
                                            <a href="{{ url('employee/profile/'.$items->user_id) }}">{{ $items->name }}<span>{{ $items->position }}</span></a>
                                        </h2>
                                    </td>
                                    <td >{{ $items->user_id }}</td>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td hidden class="name">{{ $items->name }}</td>
                                    <td hidden class="basic">{{ $items->basic }}</td>
                                    <td hidden class="da">{{ $items->da }}</td>
                                    <td hidden class="hra">{{ $items->hra }}</td>
                                    <td hidden class="conveyance">{{ $items->conveyance }}</td>
                                    <td hidden class="allowance">{{ $items->allowance }}</td>
                                    <td hidden class="medical_allowance">{{ $items->medical_allowance }}</td>
                                    <td hidden class="tds">{{ $items->tds }}</td>
                                    <td hidden class="esi">{{ $items->esi }}</td>
                                    <td hidden class="pf">{{ $items->pf }}</td>
                                    <td hidden class="leave">{{ $items->leave }}</td>
                                    <td hidden class="prof_tax">{{ $items->prof_tax }}</td>
                                    <td hidden class="labour_welfare">{{ $items->labour_welfare }}</td>
                                    <td >{{ $items->email }}</td>
                                    <td >{{ $items->department }}</td>
                                    <td >Rp {{ number_format($items->basic, 0, ',', '.') }}</td>
                                    <td hidden class="salary">{{ $items->basic }}</td>

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
                                        <select class="select select2s-hidden-accessible @error('name') is-invalid @enderror custom-select" tabindex="-1" aria-hidden="true" id="name" name="name">
                                            <option value="">-- Select --</option>
                                            @foreach ($userList as $key=>$user )
                                                <option value="{{ $user->name }}" data-employee_id="{{ $user->user_id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <input class="form-control" type="hidden" name="user_id" id="employee_id" readonly>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <h4 class="text-primary">Earnings</h4>
                                    
                                    <div class="form-group">
                                        <label>THP</label>
                                        <input 
                                            class="form-control @error('basic') is-invalid @enderror" 
                                            type="text" 
                                            name="basic" 
                                            id="basic" 
                                            value="{{ old('basic') }}" 
                                            placeholder="Masukan THP"
                                            inputmode="numeric"
                                            data-type="currency">
                                        @error('basic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Uang Lembur</label>
                                        <input 
                                        class="form-control @error('da') is-invalid @enderror" 
                                        type="number"  
                                        name="da" 
                                        id="da" 
                                        value="{{ old('da') }}" 
                                        placeholder="Masukan Uang Lembur">
                                        @error('da')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Tunjangan Shift</label>
                                        <input 
                                        class="form-control @error('hra') is-invalid @enderror" 
                                        type="number"  
                                        name="hra" 
                                        id="hra" 
                                        value="{{ old('hra') }}" 
                                        placeholder="Masukan Tunjangan Shift">
                                        @error('hra')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Insentif Keahlian</label>
                                        <input 
                                        class="form-control @error('conveyance') is-invalid @enderror" 
                                        type="text"  
                                        name="conveyance" 
                                        id="conveyance" 
                                        value="{{ old('conveyance') }}" 
                                        placeholder="Masukan Jumlah Insentif"
                                        data-type="currency">
                                        @error('conveyance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Transport</label>
                                        <input 
                                        class="form-control @error('allowance') is-invalid @enderror" 
                                        type="text"  
                                        name="allowance" 
                                        id="allowance" 
                                        value="{{ old('allowance') }}" 
                                        placeholder="Masukan Rate Lembur"
                                        data-type="currency">
                                        @error('allowance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Kompensasi Lain-Lain</label>
                                        <input 
                                        class="form-control @error('medical_allowance') is-invalid @enderror" 
                                        type="text" 
                                        name="medical_allowance" 
                                        id="medical_allowance" 
                                        value="{{ old('medical_allowance') }}" 
                                        placeholder="Masukan Rate Shift"
                                        data-type="currency">
                                        @error('medical_allowance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <h4 class="text-primary">Deduction</h4>
                                    <div class="form-group">
                                        <label>Pajak</label>
                                        <input 
                                        class="form-control @error('tds') is-invalid @enderror" 
                                        type="text" 
                                        name="tds" 
                                        id="tds" 
                                        value="{{ old('tds') }}" 
                                        placeholder="Masukan Pajak"
                                        data-type="currency">
                                        @error('tds')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="form-group">
                                        <label>Proporsional</label>
                                        <input class="form-control @error('esi') is-invalid @enderror" type="number" name="esi" id="esi" value="{{ old('esi') }}" placeholder="Masukan Hari Proporsional">
                                        @error('esi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>BPJS Kesehatan</label>
                                        <input class="form-control @error('pf') is-invalid @enderror" type="number" name="pf" id="pf" value="{{ old('pf') }}" placeholder="Masukan Nilai BPJS Kesehatan">
                                        @error('pf')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
                                        <input class="form-control " type="text" name="name" id="e_name" value="" readonly>
                                    </div>
                                    @error('name')
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
                                        <label>THP</label>
                                        <input class="form-control" type="text" name="basic" id="e_basic" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Lembur</label>
                                        <input class="form-control" type="text"  name="da" id="e_da" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <input class="form-control" type="text"  name="hra" id="e_hra" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Insentif Keahlian</label>
                                        <input class="form-control" type="text"  name="conveyance" id="e_conveyance" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Transport</label>
                                        <input class="form-control" type="text"  name="allowance" id="e_allowance" value="" data-type="currency">
                                    </div>
                                    <div class="form-group">
                                        <label>Kompensasi Lain-lain</label>
                                        <input class="form-control" type="text" name="medical_allowance" id="e_medical_allowance" value="" data-type="currency">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>Pajak</label>
                                        <input class="form-control" type="text" name="tds" id="e_tds" value="" data-type="currency">
                                    </div> 
                                    <div class="form-group">
                                        <label>Proporsional</label>
                                        <input class="form-control" type="text" name="esi" id="e_esi" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>BPJS Keshatan</label>
                                        <input class="form-control" type="text" name="pf" id="pf" value="">
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
        <!-- /Delete Salary Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')
        <script>
            $(document).ready(function() {
                $('.select2s-hidden-accessible').select2({
                    closeOnSelect: false
                });
            });
        </script>
        <script>
            // select auto id and email
            $('#name').on('change',function()
            {
                $('#employee_id').val($(this).find(':selected').data('employee_id'));
            });
        </script>
        {{-- update js --}}
        <script>
            $(document).on('click','.userSalary',function()
            {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.id').text());
                $('#e_name').val(_this.find('.name').text());
                $('#e_salary').val(_this.find('.salary').text());
                $('#e_basic').val(_this.find('.basic').text());
                $('#e_da').val(_this.find('.da').text());
                $('#e_hra').val(_this.find('.hra').text());
                $('#e_conveyance').val(_this.find('.conveyance').text());
                $('#e_allowance').val(_this.find('.allowance').text());
                $('#e_medical_allowance').val(_this.find('.medical_allowance').text());
                $('#e_tds').val(_this.find('.tds').text());
                $('#e_esi').val(_this.find('.esi').text());
                $('#e_pf').val(_this.find('.pf').text());
                $('#e_leave').val(_this.find('.leave').text());
                $('#e_prof_tax').val(_this.find('.prof_tax').text());
                $('#e_labour_welfare').val(_this.find('.labour_welfare').text());
            });
        </script>
         {{-- delete js --}}
    <script>
        $(document).on('click','.salaryDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>

    {{-- Curency js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all input fields with data-type="currency"
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
        });
    </script>

    {{-- Search js --}}
    <script>
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
    </script>

    <script>
        document.getElementById('file').addEventListener('change', function() {
            let fileName = this.files[0].name;
            this.nextElementSibling.textContent = fileName;
        });
    </script>
    @endsection
@endsection
