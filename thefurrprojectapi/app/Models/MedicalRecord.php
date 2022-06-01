<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'type',
        'date',
        'medical_history',
        'wellness_behavior',
        'date_of_birth',
        'species',
        'sex',
        'breed',
        'weight',
        'temp',
        'hr',
        'rr',
        'physical_exam',
        'cc_hx',
        'dx_tools',
        'tdx_dx_case',
        'treatment',
        'in_patient',
        'surgery',
        'out_patient',
        'take_home_meds_rx',
    ];
}
