<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientExpense extends Model
{
    //
    protected $table = 'patient_expenses';

    protected $fillable = [
        'patient_id','insurance_id', 'consulting','nurse','pharmacy','laboratory','cardiology','dental', 'admission', 'checkout',
        'gynaecology', 'physiotherapy','registration','status_id'
    ];
}
