<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    //

    protected $table = 'consultants';

    protected $fillable = [
        'patient_id', 'note', 'diagnosis','user_id','status_id',
    ];

    public function patient(){

        return $this->belongsTo('App\Patient');

    }
    public function user(){

        return $this->belongsTo('App\User');

    }

    public function status(){

        return $this->hasMany('App\Status');

    }
    public function insurance(){

        return $this->hasMany('App\Insurance');

    }
    public function cphamacies(){

        return $this->hasMany('App\ConsultantPhamacy');

    }
}
