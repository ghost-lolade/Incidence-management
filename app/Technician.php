<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    //
    protected $fillable = [
        'name', 'phone','terminal_id','email','tech_id'
    ];

    public function brand(){

        return $this->hasMany('App\Brand', 'id');

    }
}
