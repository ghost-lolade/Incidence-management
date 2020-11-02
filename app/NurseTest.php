<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NurseTest extends Model
{
    //
    protected $table = 'nurse_tests';

    protected $fillable = [
        'temperature', 'pulse', 'bloodpressure', 'weight', 'height','bloodgroup','patient_id'
    ];


    public function  patient()
    {

        return $this->belongsTo('App\Patient');

    }
}
