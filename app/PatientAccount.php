<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientAccount extends Model
{
    //
    protected $fillable = [
        'debit', 'credit', 'balance','discount', 'patient_id','family_id', 'status_id','user_id','paymentmode', 'regfee','consultfee'
    ];
}
