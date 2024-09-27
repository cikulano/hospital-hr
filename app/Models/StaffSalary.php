<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\StaffSalary;


class StaffSalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'salary',
        'thp',
        'lembur',
        'shift',
        'tunjangan_keahlian',
        'transport',
        'kompensasi',
        'pajak',
        'potongan_bpjskes',
        'potongan_jp',
        'potongan_jht',
        'benefit_bpjskes',
        'benefit_jp',
        'benefit_jht',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
