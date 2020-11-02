<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    //
    protected $table = 'insurances';


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
