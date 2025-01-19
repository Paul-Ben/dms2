<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
    public function tenant_department()
    {
        return $this->belongsTo(TenantDepartment::class, 'department_id');
    }
  
}
