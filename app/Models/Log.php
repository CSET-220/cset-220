<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function caregiver() {
        return $this->belongsTo(User::class);
    }

    public function scopePatientMissedCare($query, $patient_id, $date) {
        $query->where('patient_id', $patient_id)
            ->where('date', '<=', $date)
            ->where(function ($q) {
                $q->whereNull('morning_med')
                    ->orWhereNull('afternoon_med')
                    ->orWhereNull('night_med')
                    ->orWhereNull('breakfast')
                    ->orWhereNull('lunch')
                    ->orWhereNull('dinner');
            });
    }
    

    protected $fillable = [
        'date',
        'patient_id',
        'caregiver_id',
        'morning_med',
        'afternoon_med',
        'night_med',
        'breakfast',
        'lunch',
        'dinner'
    ];
}
