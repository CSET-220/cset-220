<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class);
    }

    public function morningPrescriptions() {
        return $this->hasMany(Prescription::class);
    }

    public function afternoonPrescriptions() {
        return $this->hasMany(Prescription::class);
    }

    public function nightPrescriptions() {
        return $this->hasMany(Prescription::class);
    }

    protected $fillable = [
        'date',
        'comments'
    ];
}
