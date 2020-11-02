<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabDiffWhiteBloodCell extends Model
{
    //
    protected $fillable = [
        'dwbc','dwbc2', 'note','patient_id','laboratory_test_id'
        ,'is_status','user_id'
    ];


    public function  patient()
    {

        return $this->belongsTo('App\Patient');

    }

    public function  labtest()
    {

        return $this->belongsTo('App\LaboratoryTest');

    }
}
