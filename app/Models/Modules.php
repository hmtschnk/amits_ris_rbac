<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model {
    protected $fillable = ['name'];

    public function functions() {
        return $this->hasMany(FunctionModule::class, 'module_id');
    }
}