<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UiLabel extends Model
{
    protected $table = 'ui_labels';
    protected $fillable = ['label_key', 'language', 'label_text'];
    public $timestamps = false;

}

