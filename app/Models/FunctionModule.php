<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionModule extends Model
{
    
    protected $table = 'function_modules';
    protected $fillable = [
        'function_id', 
        'function_name', 
        'description', 
        'module_id', 
        'module_name'
    ];

    
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'function_module_id');
    }
}