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


class PayrollController extends Controller
{
    /** view page salary */
    public function salary()
    {
        $users            = DB::table('users')->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.user_id')->select('users.*', 'staff_salaries.*')->get(); 
        $userList         = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('payroll.employeesalary',compact('users','userList','permission_lists'));
    }

     /** save record */
     public function saveRecord(Request $request)
     {
     $request->validate([
         'name'         => 'required|string|max:255',
         // 'salary'       => 'required|string|max:255',
         'basic' => 'required|string|max:255',
         'da'    => 'required|string|max:255',
         'hra'    => 'required|string|max:255',
         'conveyance' => 'required|string|max:255',
         'allowance'  => 'required|string|max:255',
         'medical_allowance' => 'required|string|max:255',
         'tds' => 'required|string|max:255',
         'esi' => 'required|string|max:255',
         // 'pf'  => 'required|string|max:255',
         // 'leave'    => 'required|string|max:255',
         // 'prof_tax' => 'required|string|max:255',
         // 'labour_welfare' => 'required|string|max:255',
     ]);
 
     DB::beginTransaction();
     try {
         $salary = StaffSalary::updateOrCreate(['user_id' => $request->user_id]);
         $salary->name              = $request->name;
         $salary->user_id           = $request->user_id;
         // $salary->salary            = $request->salary;
         $salary->basic             = $this->currencyToFloat($request->basic);
         $salary->da                = $this->currencyToFloat($request->da);
         $salary->hra               = $this->currencyToFloat($request->hra);
         $salary->conveyance        = $this->currencyToFloat($request->conveyance);
         $salary->allowance         = $this->currencyToFloat($request->allowance);
         $salary->medical_allowance = $this->currencyToFloat($request->medical_allowance);
         $salary->tds               = $this->currencyToFloat($request->tds);
         $salary->esi               = $this->currencyToFloat($request->esi);
         // $salary->pf                = $request->pf;
         // $salary->leave             = $request->leave;
         // $salary->prof_tax          = $request->prof_tax;
         // $salary->labour_welfare    = $request->labour_welfare;
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
                // ->join('profile_information', 'users.user_id', 'profile_information.user_id')
                ->select('users.*', 'staff_salaries.*')
                ->where('staff_salaries.user_id',$user_id)->first();
        // if (!empty($users)) {
        //     return view('payroll.salaryview',compact('users'));
        // } else {
        //     Toastr::warning('Please update information user :)','Warning');
        //     return redirect()->route('profile_user');
        // }

        return view('payroll.salaryview',compact('users'));
    }

    /** update record */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try{
            $update = [

                'id'      => $request->id,
                'name'    => $request->name,
                // 'salary'  => $request->salary,
                'basic'   => $request->basic,
                'da'      => $request->da,
                'hra'     => $request->hra,
                'conveyance' => $request->conveyance,
                'allowance'  => $request->allowance,
                'medical_allowance'  => $request->medical_allowance,
                'tds'  => $request->tds,
                'esi'  => $request->esi,
                'pf'   => $request->pf,
                'leave'     => $request->leave,
                'prof_tax'  => $request->prof_tax,
                'labour_welfare'  => $request->labour_welfare,
            ];


            StaffSalary::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Salary updated successfully :)','Success');
            return redirect()->back();

        }catch(\Exception $e){
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
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user_id = $request->user_id;
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
            ->first();
    
        // Prepare the logo
        $logoPath = public_path('img/logo.png');
        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
        $logoData = file_get_contents($logoPath);
        $logoBase64 = base64_encode($logoData);
        $logoSrc = 'data:image/' . $logoType . ';base64,' . $logoBase64;
    
        $pdf = PDF::loadView('report_template.salary_pdf', [
            'users' => $users,
            'logoSrc' => $logoSrc
        ])->setPaper('a4', 'portrait');
            
        $fileName = "Slip Upah {$users->name}.pdf";
    
        return $pdf->download($fileName);
    }

    /** show salary report */
    public function salaryReportHtml(Request $request)
    {
        $user_id = $request->user_id;
        $users = DB::table('users')
            ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
            ->first();

        // Prepare the logo
        $logoPath = public_path('img/logo.png');
        $logoSrc = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSrc = 'data:image/png;base64,' . $logoData;
        }

        return view('report_template.salary_html', compact('users', 'logoSrc'));
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

}
