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

    public function scopePatientMissedAppointment($query, $patient_id, $date) {
        $query->where('patient_id', $patient_id)
            ->whereNull('comments')
            ->where('date', '<', $date);
    }

    protected $fillable = [
        'date',
        'patient_id',
        'doctor_id',
        'comments'
    ];

    function scopePatientAppointmentSearch($query, $date, $patient_id) {
        $query->where('date', $date)->where('patient_id', $patient_id);
    }
    function scopeGetLastAppointment($query,$patient_id){
        $query->where('patient_id', $patient_id)->where('date', '<', date('Y-m-d'))->where('comments', '!=', null)->orderBy('date', 'desc')->first();
    }
}
