<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryFormatExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            // You can add a sample row here if you want
            // ['user_id', 'name', 'basic', 'da', 'hra', 'conveyance', 'allowance', 'medical_allowance', 'tds', 'esi', 'pf', 'leave', 'prof_tax', 'labour_welfare'],
        ];
    }

    public function headings(): array
    {
        return [
            'user_id',
            'name',
            'basic',
            'da',
            'hra',
            'conveyance',
            'allowance',
            'medical_allowance',
            'tds',
            'esi',
            'pf',
            'leave',
            'prof_tax',
            'labour_welfare',
        ];
    }
}
