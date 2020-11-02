<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requester extends Model
{
    //
	

    protected $fillable = [
        'name', 'email', 'requester_id','requester_phone','requester_dept'
		];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
//protected $guarded = ['remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   
}
