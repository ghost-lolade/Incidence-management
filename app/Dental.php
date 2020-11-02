<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dental extends Model
{
    //

    protected $fillable = [
        'status_id', 'dentals_note','user_id','patient_id'
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
