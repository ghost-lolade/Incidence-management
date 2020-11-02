<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabUrineMicroscopy extends Model
{
    //
    protected $fillable = [
        'um','um2', 'note','patient_id','laboratory_test_id'
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
