<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantPhamacy extends Model
{
    //
    protected $fillable = [
        'consultant_id', 'drug_name','drug_dosage','user_id','patient_id', 'is_status'
    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
    public function status(){

        return $this->belongsTo('App\Status');

    }
    public function toAttend(){

        return $this->belongsTo('App\ConsultantAttendTo');

    }
}
