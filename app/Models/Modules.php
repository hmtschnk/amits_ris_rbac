<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model {
    protected $table = 'modules'; 
    public $timestamps = false;
    protected $fillable = ['module_name', 'description'];

    public function functions() {
        return $this->hasMany(FunctionModule::class, 'module_id');
    }
}