<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tenant_departments()
    {
        return $this->hasMany(TenantDepartment::class);
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
