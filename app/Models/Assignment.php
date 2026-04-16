<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignment';

    public $timestamps = false;
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
