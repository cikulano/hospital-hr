<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new User([
            'user_id'      => $row['user_id'],
            'name'         => $row['name'],
            'email'        => $row['email'],
            'phone_number' => $row['phone'],
            'role_name'    => $row['role_name'],
            'position'     => $row['position'],
            'department'   => $row['department'],
            'status'       => $row['status'],
            'password'     => Hash::make($row['password']),
            'avatar'       => 'photo_defaults.jpg',
            'join_date'    => now(),
            'last_login'   => now(),
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::unique('users', 'user_id')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            // Add other validation rules as needed
        ];
    }
}
