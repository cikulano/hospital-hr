<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserFormatExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Name',
            'Email',
            'Phone',
            'Role Name',
            'Position',
            'Department',
            'Status',
            'Password',
        ];
    }
}
