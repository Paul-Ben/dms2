<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [ 
    'user_id', 
    'nin_number', 
    'gender', 
    'phone_number', 
    'designation', 
    'avatar', 
    'signature', 
    'department_id', 
    'tenant_id', 
    'account_type',
    'company_name',
    'rc_number',
    'company_address',
];

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
