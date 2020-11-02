<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantAttendTo extends Model
{
    protected $fillable = [
        'patient_id', 'attend_to', 'user_id','status_id',
    ];
    public function patient(){

        return $this->belongsTo('App\Patient');

    }

    public function user(){

        return $this->belongsTo('App\User', 'user_id');

    }

    public function status() {
        return $this->belongsTo('App\Status', 'status_id');
    }

}
