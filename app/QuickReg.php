<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickReg extends Model
{
    //
    protected $table = 'quick_regs';

    protected $fillable = [
         'surname', 'firstname', 'othername', 'address','phone',
        'state', 'birthdate', 'email','gender', 'nok', 'nokphone','picture'
    ];
    public function insurance(){

        return $this->belongsTo('App\Insurance');

    }

    public function status(){

    return $this->belongsTo('App\Status');

}

}
