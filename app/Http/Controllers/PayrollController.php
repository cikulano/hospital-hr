<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use ZipArchive;
use App\Exports\SalaryExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StaffSalary;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Imports\SalaryImport;
use App\Exports\SalaryFormatExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SalarySlipMail;
use Exception;
use Illuminate\Support\Facades\Log;


class PayrollController extends Controller
{
    /** view page salary */
    public function salary()
    {
        $users = DB::table('users')
            ->rightJoin('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('position_types', 'users.position_id', '=', 'position_types.id')
            ->leftJoin('role_type_users', 'users.role_id', '=', 'role_type_users.id')
            ->select('users.*', 'staff_salaries.*', 
                    'departments.department as department_name', 
                    'position_types.position as position_name',
                    'role_type_users.role_type as role_type',
                    'users.user_id as nopeg'
                    )
            ->get();    

        $userList = DB::table('users')
            ->whereNotIn('users.id', function($query) {
                $query->select('user_id')->from('staff_salaries');
            })
            ->leftJoin('position_types', 'users.position_id', '=', 'position_types.id')
            ->leftJoin('role_type_users', 'users.role_id', '=', 'role_type_users.id')
            ->select('users.id', 'users.name', 'users.user_id', 
                    'position_types.position as position_name',
                    'role_type_users.role_type as role_type')
            ->get();

        $permission_lists = DB::table('permission_lists')->get();
        $departments = DB::table('departments')->pluck('department');

        return view('payroll.employeesalary', compact('users', 'userList', 'permission_lists', 'departments'));
    }   

     /** save record */
     public function saveRecord(Request $request)
     {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'salary'    => 'required',
            'thp'       => 'required',
            'lembur'    => 'required',
            'shift'     => 'required',
            'tunjangan_keahlian' => 'required',
            'transport' => 'required',
            'kompensasi' => 'required',
            'pajak'     => 'required',
            'proporsional' => 'required',
            'potongan_bpjskes' => 'required',
            'potongan_jp' => 'required',
            'potongan_jht' => 'required',
            'benefit_bpjskes' => 'required',
            'benefit_jp' => 'required',
            'benefit_jht' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $salary = new StaffSalary();
            $salary->user_id = $request->user_id;
            $salary->salary = $this->currencyToFloat($request->salary);
            $salary->thp = $this->currencyToFloat($request->thp);
            $salary->lembur = $this->currencyToFloat($request->lembur);
            $salary->shift = $this->currencyToFloat($request->shift);
            $salary->tunjangan_keahlian = $this->currencyToFloat($request->tunjangan_keahlian);
            $salary->transport = $this->currencyToFloat($request->transport);
            $salary->kompensasi = $this->currencyToFloat($request->kompensasi);
            $salary->pajak = $this->currencyToFloat($request->pajak);
            $salary->proporsional = $this->currencyToFloat($request->proporsional);
            $salary->potongan_bpjskes = $this->currencyToFloat($request->potongan_bpjskes);
            $salary->potongan_jp = $this->currencyToFloat($request->potongan_jp);
            $salary->potongan_jht = $this->currencyToFloat($request->potongan_jht);
            $salary->benefit_bpjskes = $this->currencyToFloat($request->benefit_bpjskes);
            $salary->benefit_jp = $this->currencyToFloat($request->benefit_jp);
            $salary->benefit_jht = $this->currencyToFloat($request->benefit_jht);
            $salary->save();

            DB::commit();
            Toastr::success('Salary added successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Error adding salary: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
     }
 
     /** Revert back */
     private function currencyToFloat($value)
     {
         // Remove 'Rp ' prefix and any commas
         $cleanValue = str_replace(['Rp ', ','], '', $value);
         // Convert to float
         return (float) $cleanValue;
     }
 
    /** salary view detail */
    public function salaryView($user_id)
    {
        $users = DB::table('users')
                ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
                ->select('users.*', 'staff_salaries.*')
                ->where('staff_salaries.user_id',$user_id)->first();

        return view('payroll.salaryview',compact('users'));
    }

    /** update record */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = StaffSalary::findOrFail($request->id);
            $salary->salary = $this->currencyToFloat($request->salary);
            $salary->thp = $this->currencyToFloat($request->thp);
            $salary->lembur = $this->currencyToFloat($request->lembur);
            $salary->shift = $this->currencyToFloat($request->shift);
            $salary->tunjangan_keahlian = $this->currencyToFloat($request->tunjangan_keahlian);
            $salary->transport = $this->currencyToFloat($request->transport);
            $salary->kompensasi = $this->currencyToFloat($request->kompensasi);
            $salary->pajak = $this->currencyToFloat($request->pajak);
            $salary->proporsional = $this->currencyToFloat($request->proporsional);
            $salary->potongan_bpjskes = $this->currencyToFloat($request->potongan_bpjskes);
            $salary->potongan_jp = $this->currencyToFloat($request->potongan_jp);
            $salary->potongan_jht = $this->currencyToFloat($request->potongan_jht);
            $salary->benefit_bpjskes = $this->currencyToFloat($request->benefit_bpjskes);
            $salary->benefit_jp = $this->currencyToFloat($request->benefit_jp);
            $salary->benefit_jht = $this->currencyToFloat($request->benefit_jht);
            $salary->save();

            DB::commit();
            Toastr::success('Salary updated successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Salary update fail :)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            StaffSalary::destroy($request->id);

            DB::commit();
            Toastr::success('Salary deleted successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Salary deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** payroll Items */
    public function payrollItems()
    {
        return view('payroll.payrollitems');
    }

    public function salaryReportHtml($user_id)
    {
        $users = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')  // Ensure this join is correct
            ->select('users.*', 
            'staff_salaries.*', 
            'departments.department as department_name',
            'users.user_id as nopeg'
            )  // Alias the department column
            ->where('users.id', $user_id)
            ->first();

        if (!$users) {
            Log::error('No user found with id:', ['user_id' => $user_id]);
            // Consider returning an error or a view with an error message
        }

        $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
        $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));

        return view('report_template.salary_html', compact('users', 'logo1Src', 'logo2Src'));
    }

    /** report pdf */  
    public function reportPDF(Request $request)
    {
        $user_id = $request->user_id;
        $users = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->select(
                'users.*', 
                'staff_salaries.*', 
                'departments.department as department_name',
                'users.user_id as nopeg'
            )
            ->where('users.id', $user_id)
            ->first();

            $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
            $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));
        
            $pdf = PDF::loadView('report_template.salary_pdf', [
                'users' => $users,
                'logo1Src' => $logo1Src,
                'logo2Src' => $logo2Src
            ])->setPaper('a4', 'portrait');
            
        $fileName = "Slip Upah {$users->name}.pdf";
        $pdfContent = $pdf->output();

        // Send email
        Mail::to($users->email)->send(new SalarySlipMail($pdfContent, $fileName));

        return $pdf->download($fileName);
    }

    public function salaryReportPdfHtml($user_id)
    {
        $users = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->select(
                'users.*', 
                'staff_salaries.*', 
                'departments.department as department_name',
                'users.user_id as nopeg'
            )
            ->where('users.id', $user_id)
            ->first();

        if (!$users) {
            Log::error('No user found with id:', ['user_id' => $user_id]);
            return back()->withErrors(['msg' => 'User not found']);
        }

        $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
        $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));

        return view('report_template.salary_pdf', [
            'users' => $users,
            'logo1Src' => $logo1Src,
            'logo2Src' => $logo2Src
        ]);
    }
    
    /** export Excel */
    public function reportExcel(Request $request)
    {
        $user_id = $request->user_id;
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->join('profile_information', 'users.user_id', 'profile_information.user_id')
            ->select('users.*', 'staff_salaries.*','profile_information.*')
            ->where('staff_salaries.user_id',$user_id)->get();
            
            return Excel::download(new SalaryExcel($user_id),'ReportDetailSalary'.'.xlsx');
    }

    /** Import Excel */
    public function importSalary(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new SalaryImport, $request->file('file'));
            Toastr::success('Salary data imported successfully :)', 'Success');
        } catch (\Exception $e) {
            Toastr::error('Error importing salary data: ' . $e->getMessage(), 'Error');
        }

        return redirect()->back();
    }

    /** Download Format Excel */
    public function downloadFormat()
    {
        return Excel::download(new SalaryFormatExport, 'salary_import_format.xlsx');
    }

    /** Search and Filter */
    public function getSalaryData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $user_name = $request->user_name;
        $position = $request->position;
        $department = $request->department;

        $query = StaffSalary::select(
            'staff_salaries.*', 
            'users.name', 
            'users.email', 
            'users.position', 
            'departments.department as department_name', 
            'users.avatar'
        )
        ->join('users', 'staff_salaries.user_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id');
    
        // Apply search filters
        if ($searchValue || $user_name || $position || $department) {
            $query->where(function ($q) use ($searchValue, $user_name, $position, $department) {
                if ($searchValue) {
                    $q->where('users.name', 'like', '%' . $searchValue . '%')
                      ->orWhere('users.user_id', 'like', '%' . $searchValue . '%')
                      ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                      ->orWhere('departments.department', 'like', '%' . $searchValue . '%');
                }
                if ($user_name) {
                    $q->where('users.name', 'like', '%' . $user_name . '%');
                }
                if ($position) {
                    $q->where('users.position', 'like', '%' . $position . '%');
                }
                if ($department) {
                    $q->where('departments.department', 'like', '%' . $department . '%');
                }
            });
        }

        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;

        // Apply sorting
        if ($columnName && $columnSortOrder) {
            $query->orderBy($columnName, $columnSortOrder);
        }

        // Apply pagination
        $records = $query->skip($start)
                        ->take($rowperpage)
                        ->get();

        $data_arr = [];

        foreach ($records as $record) {
            $avatar = asset_url('/assets/images/' . $record->avatar);
            $name = '<h2 class="table-avatar">
                        <a href="'.secure_asset('employee/profile/'.$record->user_id).'" class="avatar"><img alt="" src="'.$avatar.'"></a>
                        <a href="'.url('employee/profile/'.$record->user_id).'">'.$record->name.'<span>'.$record->position.'</span></a>
                    </h2>';

            $generate_slip = '<a class="btn btn-sm btn-success" href="'.route('extra.report.html', ['user_id' => $record->user_id]).'" target="_blank">Generate Slip</a>';

            $action = '<a class="userSalary btn-edit" href="#" data-toggle="modal" data-target="#edit_salary">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a class="salaryDelete btn-delete" href="#" data-toggle="modal" data-target="#delete_salary">
                        <i class="fa fa-trash-o"></i>
                    </a>';

            $data_arr[] = [
                "name" => $name,
                "user_id" => $record->user_id,
                "id" => $record->id,
                "salary" => $record->salary,
                "thp" => $record->thp,
                "lembur" => $record->lembur,
                "shift" => $record->shift,
                "tunjangan_keahlian" => $record->tunjangan_keahlian,
                "transport" => $record->transport,
                "kompensasi" => $record->kompensasi,
                "pajak" => $record->pajak,
                "proporsional" => $record->proporsional,
                "potongan_bpjskes" => $record->potongan_bpjskes,
                "potongan_jp" => $record->potongan_jp,
                "potongan_jht" => $record->potongan_jht,
                "benefit_bpjskes" => $record->benefit_bpjskes,
                "benefit_jp" => $record->benefit_jp,
                "benefit_jht" => $record->benefit_jht,
                "email" => $record->email,
                "department" => $record->department_name,
                "formatted_salary" => 'Rp ' . number_format($record->salary, 0, ',', '.'),
                "generate_slip" => $generate_slip,
                "action" => $action
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return response()->json($response);
    }
    
    public function bulkDownloadPDF($department)
    {
        Log::info("Starting bulk download for department: {$department}");

    try {
        // Decode the URL-encoded department name
        $decodedDepartment = urldecode($department);

        // Replace '+' with space and trim
        $cleanedDepartment = trim(str_replace('+', ' ', $decodedDepartment));

        // Join the users table with the departments table and staff_salaries table
        $users = User::join('departments', 'users.department_id', '=', 'departments.id')
        ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
        ->where(function($query) use ($cleanedDepartment) {
            $query->where('departments.department', $cleanedDepartment)
                  ->orWhere('departments.department', 'like', '%' . str_replace(' ', '%', $cleanedDepartment) . '%');
        })
        ->select('users.id as user_id', 'users.name')
        ->get();

        Log::info("Found " . $users->count() . " users in department: {$cleanedDepartment}");

        if ($users->isEmpty()) {
            Log::warning("No users with salary information found in department: {$cleanedDepartment}");
                return response()->json(['error' => 'No users with salary information found in this department'], 404);
            }

        $zip = new ZipArchive;
        $zipFileName = 'salary_slips_' . str_replace(' ', '_', $decodedDepartment) . '.zip';
        $zipPath = storage_path($zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $pdfGeneratedCount = 0;
            $failedUsers = [];

            foreach ($users as $user) {
                $pdf = $this->generatePDF($user->user_id);
                if ($pdf) {
                    $zip->addFromString("salary_slip_{$user->name}_{$user->user_id}.pdf", $pdf->output());
                    $pdfGeneratedCount++;
                } else {
                    $failedUsers[] = $user->user_id;
                    Log::warning("Failed to generate PDF for user: {$user->user_id}");
                }
            }
            $zip->close();

            if ($pdfGeneratedCount === 0) {
                Log::error("No PDFs were generated for department: {$decodedDepartment}");
                return response()->json(['error' => 'No salary slips could be generated'], 500);
            }

            $message = "{$pdfGeneratedCount} PDFs generated successfully.";
            if (!empty($failedUsers)) {
                $message .= " Failed to generate PDFs for users: " . implode(', ', $failedUsers);
            }
            Log::info($message);

            return response()->download($zipPath)->deleteFileAfterSend(true);
        } else {
            throw new Exception("Cannot create zip file");
        }
    } catch (\Exception $e) {
        Log::error('Failed to create bulk download: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to create bulk download: ' . $e->getMessage()], 500);
        }
    }

    private function generatePDF($user_id)
    {
        $users = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->select(
            'users.*', 
            'staff_salaries.*', 
            'departments.department as department_name',
            'users.user_id as nopeg'
        )
        ->where('users.id', $user_id)
        ->first();

    if (!$users) {
        Log::error("No salary information found for user_id: {$user_id}");
        return null;
    }

    try {
        $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
        $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));

        $pdf = PDF::loadView('report_template.salary_pdf', compact('users', 'logo1Src', 'logo2Src'));
        
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf;
    } catch (\Exception $e) {
        Log::error("Error generating PDF for user_id: {$user_id}. Error: " . $e->getMessage());
        return null;
        }
    }

    public function sendEmail($user_id)
    {
        try {
            $user = User::where('user_id', $user_id)->firstOrFail();
            Log::info('User found', ['user_id' => $user_id, 'email' => $user->email]);

            $users = DB::table('users')
                ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
                ->select('users.*', 'staff_salaries.*')
                ->where('staff_salaries.user_id', $user_id)
                ->first();

            if (!$users) {
                throw new Exception('User salary information not found');
            }

            $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
            $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));

            $pdfHtml = view('report_template.salary_pdf', compact('users', 'logo1Src', 'logo2Src'))->render();
            Log::info('PDF HTML generated');

            $pdf = PDF::loadHTML($pdfHtml);
            $pdfContent = $pdf->output();
            Log::info('PDF generated');

            $fileName = 'Slip Upah ' . $user->name . '.pdf';

            Mail::to($user->email)->send(new SalarySlipMail($user, $pdfContent, $fileName));
            Log::info('Email sent successfully');

            return response()->json(['success' => true, 'message' => 'Email sent successfully']);
        } catch (Exception $e) {
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }

    // Search by Department
    public function searchByDepartment(Request $request)
    {
        $department = $request->department;

        $users = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('position_types', 'users.position_id', '=', 'position_types.id')
            ->select(
                'users.name', 
                'users.user_id as nopeg', 
                'users.email', 
                'departments.department as department_name', 
                'staff_salaries.salary',
                'users.avatar',
                'position_types.position as position_name'
            )
            ->where('departments.department', $department)
            ->get();

        return response()->json($users);
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $department = $request->department;

        $query = DB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('position_types', 'users.position_id', '=', 'position_types.id')
            ->select(
                'users.id as user_id',
                'users.name',
                'users.user_id as nopeg',
                'users.email',
                'users.avatar',
                'departments.department as department_name',
                'position_types.position as position_name',
                'staff_salaries.salary'
            );

        if ($name) {
            $query->where('users.name', 'LIKE', "%{$name}%");
        }

        if ($department) {
            $query->where('departments.department', $department);
        }

        $users = $query->get();

        return response()->json($users);
    }
}