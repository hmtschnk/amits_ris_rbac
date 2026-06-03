<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionModule extends Model
{ 
    protected $table = 'function_module';
    public $timestamps = false;
    protected $fillable = [
        'module_id', 
        'function_id', 
        'function_name', 
        'description', 
        
        
    ];

    public function modules() {
        return $this->belongsTo(Modules::class, 'module_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'function_module_id');
    }
}
