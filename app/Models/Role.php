<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    public function user() {
        $this->hasMany(User::class);
    }

    protected $fillable = [
        'role_title',
        'access_level'
    ];
}
