<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    public function morning_med() {
        return $this->belongsTo(Appointment::class, 'morning_med');
    }

    public function afternoon_med() {
        return $this->belongsTo(Appointment::class, 'afternoon_med');
    }

    public function night_med() {
        return $this->belongsTo(Appointment::class, 'night_med');
    }

    protected $fillable = [
        'medication_name',
        'medication_dosage'
    ];
}
