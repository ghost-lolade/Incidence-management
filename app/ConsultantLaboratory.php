<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantLaboratory extends Model
{
    //
    protected $fillable = [
        'consultant_id', 'lab_test','user_id','patient_id'
    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
    public function patient(){

        return $this->belongsTo('App\Patient');

    }
    public function status(){

        return $this->belongsTo('App\Status');

    }
    public function toAttend(){

        return $this->belongsTo('App\ConsultantAttendTo');

    }
}
