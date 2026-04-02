<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'name', 'email', 'password', 'role_id', 'status',
        'title', 'qualification', 'mmc_no', 'nsr_no', 'clinic_name',
        'address1', 'address2', 'address3', 'address4', 'postal', 'city',
        'country', 'created_by', 'updated_by', 'state', 'phone', 
        'company_id', 'activated_at', 'activated_by', 'position', 
        'group_id', 'notice_at', 'language'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsTo(Role::class);
    }
}