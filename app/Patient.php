<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    //
    protected $table = 'patients';

    protected $fillable = [
        'family_id', 'surname', 'firstname', 'othername', 'address','city_id', 'state_id', 'country_id',
        'phone', 'phone2', 'insurance_id', 'birthdate', 'email','gender', 'nok', 'nokphone','picture',
    ];

    public function insurance(){

        return $this->belongsTo('App\Insurance');

    }
    public function city(){

        return $this->belongsTo('App\City');

    }
    public function state(){

        return $this->belongsTo('App\State');

    }
    public function country(){

        return $this->belongsTo('App\Country');

    }public function status(){

        return $this->belongsTo('App\Status');

    }

}
