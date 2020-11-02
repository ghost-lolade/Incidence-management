<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = 'statuses';

    protected $fillable = [
        'patient_id','insurance_id', 'consulting','nurse','pharmacy','laboratory','cardiology','dental', 'admission', 'checkout',
        'gynaecology', 'physiotherapy'
    ];
    public function patient(){

        return $this->belongsTo('App\Patient');

    }
    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }

    public function quickreg(){

        return $this->belongsTo('App\QuickReg');
    }
    public function sale(){

        return $this->hasMany('App\Sale');
    }
    public function patexpenses(){

        return $this->hasMany('App\PatientExpense');
    }
    public function laboratory(){

        return $this->hasMany('App\Laboratory');
    }
}
