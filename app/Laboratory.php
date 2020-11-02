<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    //
    protected $fillable = [
      'total_price', 'lab_fee_id','user_id','status_id','laboratory_id','patient_id','amount_deposit','payment_status',
        'is_status'

    ];

    public function consultant(){

        return $this->belongsTo('App\Consultant');

    }
    public function patient(){

        return $this->belongsTo('App\Patient');

    }
//   public function status(){
//
//        return $this->belongsTo('App\Status');
//
//    }
    public function labtest(){

        return $this->belongsTo('App\LaboratoryTest', 'laboratory_test_id');

    }
public function labtests(){

        return $this->hasMany('App\LaboratoryTest');

    }

    public function labfee(){

        return $this->belongsTo('App\LabFee');

    }
}
