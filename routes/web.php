<?php

use Illuminate\Support\Facades\Route;

// ... (previous code remains unchanged)

Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    // ... (previous routes remain unchanged)

    // ------------------------ form payroll  ----------------------------//
    Route::controller(PayrollController::class)->group(function () {
        Route::get('form/salary/page', 'salary')->middleware('auth')->name('form/salary/page');
        Route::post('form/salary/save','saveRecord')->middleware('auth')->name('form/salary/save');
        Route::post('form/salary/update', 'updateRecord')->middleware('auth')->name('form/salary/update');
        Route::post('form/salary/delete', 'deleteRecord')->middleware('auth')->name('form/salary/delete');
        Route::get('form/salary/view/{user_id}', 'salaryView')->middleware('auth');
        Route::get('form/payroll/items', 'payrollItems')->middleware('auth')->name('form/payroll/items');    
        Route::get('extra/report/pdf', 'reportPDF')->middleware('auth');    
        Route::get('extra/report/excel', 'reportExcel')->middleware('auth');
        Route::get('extra/report/html/{user_id}', 'salaryReportHtml')->middleware('auth')->name('extra.report.html');
        Route::get('extra/report/pdf-html/{user_id}', 'salaryReportPdfHtml')->middleware('auth')->name('salary.pdf.html');
        Route::get('extra/report/email', 'emailPDF')->middleware('auth')->name('extra.report.email');
        Route::post('salary/import', 'PayrollController@importSalary')->middleware('auth')->name('salary.import');
        Route::get('salary/format/download', 'PayrollController@downloadFormat')->middleware('auth')->name('salary.format.download');
        Route::get('search/employees', 'searchEmployees')->middleware('auth')->name('search.employees');
        // New route for bulk download
        Route::get('salary/department/{department}', 'generateDepartmentSalaries')->middleware('auth')->name('salary.department');
     });

    // ... (rest of the code remains unchanged)
});
