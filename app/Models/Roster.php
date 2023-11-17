<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roster extends Model
{
    use HasFactory;

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function supervisor() {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function caregiver1() {
        return $this->belongsTo(User::class, 'caregiver1_id');
    }

    public function caregiver2() {
        return $this->belongsTo(User::class, 'caregiver2_id');
    }

    public function caregiver3() {
        return $this->belongsTo(User::class, 'caregiver3_id');
    }

    public function caregiver4() {
        return $this->belongsTo(User::class, 'caregiver4_id');
    }

    protected $fillable = [
        'date'
    ];
}
