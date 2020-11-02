<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantAppointment extends Model
{
    //
    protected $fillable = [
        'consultant_id', 'scheduler_date','schedule_notes','patient_id','subject','user_id'
    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }

    public function patient(){

        return $this->belongsTo('App\Patient');

    }
    public function user(){

        return $this->belongsTo('App\User');

    }
}
