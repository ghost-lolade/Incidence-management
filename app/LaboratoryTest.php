<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryTest extends Model
{

    protected $table = 'laboratory_tests';
    //
    protected $fillable = [
        'amount', 'lab_fee_id','user_id','status','laboratory_id',
    ];
// CRAZY THINGS HAPPENING HERE
    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
    public function status(){

        return $this->belongsTo('App\Status');

    }
    public function toAttend(){

        return $this->belongsTo('App\ConsultantAttendTo');

    }
    public function user(){

        return $this->belongsTo('App\User');

    }

//    public function labfee(){
//
//        return $this->belongsTo('App\LabFee');
//
//    }

    public function labfee() {
        return $this->belongsTo('App\LabFee', 'lab_fee_id');
    }

 public function lab() {
        return $this->hasMany('App\Laboratory', 'laboratory_id');
    }

    public function pvc(){

        return $this->hasMany('App\Pvc','laboratory_test_id');

    }
    public function reportpvc(){

        return $this->belongsTo('App\Pvc','laboratory_test_id');

    }



}
