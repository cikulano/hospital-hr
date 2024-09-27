<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\StaffSalary;
use App\Models\roleTypeUser;
use App\Models\PositionType;
use App\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'status',
        'role_id',
        'position_id',
        'department_id',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $getUser = self::orderBy('user_id', 'desc')->first();

            if ($getUser) {
                $latestID = intval(substr($getUser->user_id, 1));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }
            $model->user_id = 'P' . str_pad($nextID, 4, '0', STR_PAD_LEFT);
            while (self::where('user_id', $model->user_id)->exists()) {
                $nextID++;
                $model->user_id = 'P' . str_pad($nextID, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(roleTypeUser::class);
    }

    public function position()
    {
        return $this->belongsTo(PositionType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function staffSalary()
    {
        return $this->hasOne(StaffSalary::class);
    }
}
