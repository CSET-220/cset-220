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
        return $this->hasOne(Prescription::class ,'id', 'morning_med');
    }

    public function afternoonPrescriptions() {
        return $this->hasOne(Prescription::class, 'id','afternoon_med');
    }

    public function nightPrescriptions() {
        return $this->hasOne(Prescription::class, 'id','night_med');
    }

    // TODO might have to use date as well
    public function scopePatientMissedAppointment($query, $patient_id, $date) {
        $query->where('patient_id', $patient_id)
            ->where('date', '<=', $date);
    }

    protected $fillable = [
        'date',
        'comments'
    ];

    function scopePatientAppointmentSearch($query, $date, $patient_id) {
        $query->where('date', $date)->where('patient_id', $patient_id);
    }
}
