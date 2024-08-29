<?php

namespace App\Imports;

use App\Models\StaffSalary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalaryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new StaffSalary([
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'basic' => $row['basic'],
            'da' => $row['da'],
            'hra' => $row['hra'],
            'conveyance' => $row['conveyance'],
            'allowance' => $row['allowance'],
            'medical_allowance' => $row['medical_allowance'],
            'tds' => $row['tds'],
            'esi' => $row['esi'],
            'pf' => $row['pf'],
            'leave' => $row['leave'],
            'prof_tax' => $row['prof_tax'],
            'labour_welfare' => $row['labour_welfare'],
        ]);
    }
}
