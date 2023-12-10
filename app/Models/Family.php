<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'family_id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    protected $fillable = [
        'family_id',
        'patient_id'
    ];

    public function scopeFamilySearch($query, $patient_id, $family_id) {
        $query->where('patient_id', $patient_id)->where('family_id', $family_id);
    }

    public function scopeGetAllFamily($query, $family_id) {
        $query->where('family_id', $family_id);
    }
}
