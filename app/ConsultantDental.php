<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantDental extends Model
{
    //
    protected $fillable = [
        'consultant_id', 'dentals_note','user_id',
    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
}
