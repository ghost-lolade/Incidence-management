<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'genericname', 'description'
    ];


    public function brand(){

        return $this->belongsTo('App\Brand');

    }

    public function category(){

        return $this->belongsTo('App\Category');

    }

    public function stock(){

        return $this->hasMany('App\Stock');

    }

    public function sale(){

        return $this->hasMany('App\Sale');

    }


}
