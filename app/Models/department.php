<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class department extends Model
{
    use HasFactory;
    protected $fillable = [
        'department',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
