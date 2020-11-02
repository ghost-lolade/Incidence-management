<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorData extends Model
{
    //
    protected $fillable = [
        'name', 'phone','vendor_id','email','level'
    ];

    public function brand(){

        return $this->hasMany('App\Brand', 'id');

    }
}
