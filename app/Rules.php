<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    //
    protected $table = 'rules';

    protected $fillable = [
        'vendor_id', 'state_id', 'response_time', 'response_day','repair_time',
        'repair_day'
    ];

    public function vendor(){

        return $this->belongsTo('App\Vendor');

    }
    public function state(){

        return $this->belongsTo('App\State');

    }
}
