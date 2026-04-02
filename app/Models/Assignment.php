<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';
    protected $fillable = ['role_id', 'function_module_id', 'permission'];

    
    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    
    public function functionModule()
    {
        return $this->belongsTo(FunctionModule::class, 'function_module_id');
    }
}