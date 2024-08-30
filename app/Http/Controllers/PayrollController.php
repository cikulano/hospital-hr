<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Exports\SalaryExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StaffSalary;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Imports\SalaryImport;
use App\Exports\SalaryFormatExport;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /** view page salary */
    public function salary()
    {
        $users = DB::table('users')
        ->rightJoin('staff_salaries', 'users.user_id', '=', 'staff_salaries.user_id')
        ->select('users.*', 'staff_salaries.*')
        ->get();    
    
        $userList = DB::table('users')
            ->whereNotIn('user_id', function($query) {
                $query->select('user_id')->from('staff_salaries');
            })
            ->get();
    
        $permission_lists = DB::table('permission_lists')->get();
    
        return view('payroll.employeesalary', compact('users', 'userList', 'permission_lists'));
    }    

     /** save record */
     public function saveRecord(Request $request)
     {
        $request->validate([
            'name'         => 'required|string|max:255',
            'basic' => 'required|string|max:255',
            'da'    => 'required|string|max:255',
            'hra'    => 'required|string|max:255',
            'conveyance' => 'required|string|max:255',
            'allowance'  => 'required|string|max:255',
            'medical_allowance' => 'required|string|max:255',
            'tds' => 'required|string|max:255',
            'esi' => 'required|string|max:255',
        ]);
 
        DB::beginTransaction();
        try {
            $salary = StaffSalary::updateOrCreate(['user_id' => $request->user_id]);
            $salary->name              = $request->name;
            $salary->user_id           = $request->user_id;
            $salary->basic             = $this->currencyToFloat($request->basic);
            $salary->da                = $this->currencyToFloat($request->da);
            $salary->hra               = $this->currencyToFloat($request->hra);
            $salary->conveyance        = $this->currencyToFloat($request->conveyance);
            $salary->allowance         = $this->currencyToFloat($request->allowance);
            $salary->medical_allowance = $this->currencyToFloat($request->medical_allowance);
            $salary->tds               = $this->currencyToFloat($request->tds);
            $salary->esi               = $this->currencyToFloat($request->esi);
            $salary->save();
    
            DB::commit();
            Toastr::success('Create new Salary successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Salary fail :)','Error');
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
            $update = [
                'id'      => $request->id,
                'name'    => $request->name,
                'basic'   => $this->currencyToFloat($request->basic),
                'da'      => $this->currencyToFloat($request->da),
                'hra'     => $this->currencyToFloat($request->hra),
                'conveyance' => $this->currencyToFloat($request->conveyance),
                'allowance'  => $this->currencyToFloat($request->allowance),
                'medical_allowance'  => $this->currencyToFloat($request->medical_allowance),
                'tds'  => $this->currencyToFloat($request->tds),
                'esi'  => $this->currencyToFloat($request->esi),
                'pf'   => $this->currencyToFloat($request->pf),
                'leave'     => $request->leave,
                'prof_tax'  => $this->currencyToFloat($request->prof_tax),
                'labour_welfare'  => $this->currencyToFloat($request->labour_welfare),
            ];

            StaffSalary::where('id', $request->id)->update($update);
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

    /** report pdf */  
    public function reportPDF(Request $request)
    {
        $user_id = $request->user_id;
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
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

    public function salaryReportHtml($user_id)
    {
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
            ->first();

            $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
            $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));
        
            return view('report_template.salary_html', compact('users', 'logo1Src', 'logo2Src'));
    }

    public function salaryReportPdfHtml($user_id)
    {
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
            ->first();

            $logo1Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png')));
            $logo2Src = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo2.png')));
        
            return view('report_template.salary_pdf', compact('users', 'logo1Src', 'logo2Src'));
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
    
        $totalRecords = StaffSalary::select('count(*) as allcount')
            ->join('users', 'staff_salaries.user_id', '=', 'users.user_id')
            ->count();
    
        $totalRecordswithFilter = StaffSalary::select('count(*) as allcount')
            ->join('users', 'staff_salaries.user_id', '=', 'users.user_id')
            ->where(function ($query) use ($searchValue, $user_name, $position, $department) {
                $query->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%');
    
                if ($user_name) {
                    $query->where('users.name', 'like', '%' . $user_name . '%');
                }
                if ($position) {
                    $query->where('users.position', $position);
                }
                if ($department) {
                    $query->where('users.department', $department);
                }
            })
            ->count();
    
        $records = StaffSalary::select('staff_salaries.*', 'users.name', 'users.email', 'users.position', 'users.department', 'users.avatar')
            ->join('users', 'staff_salaries.user_id', '=', 'users.user_id')
            ->where(function ($query) use ($searchValue, $user_name, $position, $department) {
                $query->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%');
    
                if ($user_name) {
                    $query->where('users.name', 'like', '%' . $user_name . '%');
                }
                if ($position) {
                    $query->where('users.position', $position);
                }
                if ($department) {
                    $query->where('users.department', $department);
                }
            })
            ->skip($start)
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
                "basic" => $record->basic,
                "da" => $record->da,
                "hra" => $record->hra,
                "conveyance" => $record->conveyance,
                "allowance" => $record->allowance,
                "medical_allowance" => $record->medical_allowance,
                "tds" => $record->tds,
                "esi" => $record->esi,
                "pf" => $record->pf,
                "leave" => $record->leave,
                "prof_tax" => $record->prof_tax,
                "labour_welfare" => $record->labour_welfare,
                "email" => $record->email,
                "department" => $record->department,
                "formatted_basic" => 'Rp ' . number_format($record->basic, 0, ',', '.'),
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
    
    


}
