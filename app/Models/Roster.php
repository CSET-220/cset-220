<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roster extends Model
{
    use HasFactory;

    public function doctor() {
        return $this->belongsTo(User::class);
    }

    public function supervisor() {
        return $this->belongsTo(User::class);
    }

    public function caregiver1() {
        return $this->belongsTo(User::class);
    }

    public function caregiver2() {
        return $this->belongsTo(User::class);
    }

    public function caregiver3() {
        return $this->belongsTo(User::class);
    }

    public function caregiver4() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'date'
    ];
}
