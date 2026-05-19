<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReferral extends Model
{
    use HasFactory;

    protected $fillable = [
    'patient_id',
    'patient_name',
    'gender',
    'age',
    'xray_type_id',
    'birthdate',
    'patient_email',
    'referring_dr',
    'clinical_reason',
    'referring_clinic',
    'xray_panel',
 ];

    protected $casts = [
        'birthdate' => 'date',
    ];
}
