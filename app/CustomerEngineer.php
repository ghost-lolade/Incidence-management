<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerEngineer extends Model
{
    //
    protected $fillable = [
        'name', 'mobile','vendor_id','email_address','state','level'

    ];
//    public function cedetail(){
//
////        return $this->hasMany('App\CustomerEngineer');
//        return $this->hasMany('App\CallLog', 'ce_id');
//
//    }
}
