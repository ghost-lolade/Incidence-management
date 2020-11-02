<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantNurse extends Model
{
    //
    protected $fillable = [
        'consultant_id', 'nurse_note','user_id',
    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
}
