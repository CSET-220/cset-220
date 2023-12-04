<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Log;
use App\Models\Role;
use App\Models\Roster;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\SessionGuard;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function patient() {
        return $this->hasOne(Patient::class);
    }

    public function employees() {
        return $this->hasOne(Employee::class);
    }

    public function appointments() {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function logs() {
        return$this->hasMany(Log::class, 'caregiver_id');
    }

    public function doctorRosters() {
        return $this->hasMany(Roster::class, 'doctor_id');
    }

    public function supervisorRosters() {
        return $this->hasMany(Roster::class, 'supervisor_id');
    }

    public function caregiver1Rosters() {
        return $this->hasMany(Roster::class, 'caregiver1_id');
    }

    public function caregiver2Rosters() {
        return $this->hasMany(Roster::class, 'caregiver2_id');
    }

    public function caregiver3Rosters() {
        return $this->hasMany(Roster::class, 'caregiver3_id');
    }

    public function caregiver4Rosters() {
        return $this->hasMany(Roster::class, 'caregiver4_id');
    }

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'dob',
        'is_approved'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAccess(array $role_title){
        $role_ids = Role::whereIn('role_title',$role_title)->pluck('id');
        return in_Array($this->role_id, $role_ids->toArray());
    }

    public function scopeNameSearch($query, $id) {
        $query->where('id', $id);
    }
}
