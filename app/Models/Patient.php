<?php

namespace App\Models;

use App\Models\Log;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function families() {
        return $this->hasMany(Family::class);
    }

    public function logs() {
        return $this->hasMany(Log::class);
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    protected $fillable = [
        'user_id',
        'family_code',
        'emergency_contact',
        'contact_relation',
        'group',
        'admission_date',
        'last_paid_date',
        'balance'
    ];

    protected $casts = [
        'family_code' => 'encrypted'
    ];
}
