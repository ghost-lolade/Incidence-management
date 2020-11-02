<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabStoolAnalysis extends Model
{
    //
    protected $fillable = [
        'sa','sa2', 'note','patient_id','laboratory_test_id'
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
