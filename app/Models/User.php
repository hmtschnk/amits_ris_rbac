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
        return $this->belongsTo(Roles::class , 'role_id');
    }

    public function hasPermission(string $moduleName, ?string $functionName = null, string $permissionType = 'VIEW'): bool
    { 
        if (!$this->role_id) return false;

        // if ($this->roles && $this->roles->code === 'MASTER_ADMIN') {
        //     return true;
        // }

        $allowedPermissions = ($permissionType === 'VIEW') ? ['VIEW' , 'EDIT'] : [$permissionType];

            return \App\Models\Assignment::where('role_id', $this->role_id)
            ->whereHas('functionModule', function ($query) use ($moduleName, $functionName) {
                $query->whereHas('modules', function ($q) use ($moduleName) {
                    $q->where('module_name', $moduleName); 
                });
                
                if (!empty($functionName) && $functionName !== 'null'){
                    $query->where('function_name', $functionName);
                }
            })
            ->whereIn('permission', $allowedPermissions)
            ->exists();
    }

    public function hasAnyPermission(array $moduleNames, string $permissionType = 'VIEW'): bool
    {
        foreach ($moduleNames as $moduleName) {
            if ($this->hasPermission($moduleName, null, $permissionType)) {
                return true;
            }
        }
        return false;
    }
    
    // public function hasRoles(array|string $roles)
    // {
    //     if (!$this->roles) {
    //         return false;
    //     }

    //     $roles = is_array($roles) ? $roles : [$roles];
    //     return $this->roles()->whereIn('code', $roles)->exists();
    // }
}



