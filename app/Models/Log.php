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
