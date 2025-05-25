<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantDepartment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function userDetails()
    {
        return $this->hasMany(UserDetails::class);
    }
}
