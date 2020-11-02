<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPM extends Model
{
    //
    protected $table = 'vendor_p_ms';


    protected $fillable = ['terminal_id','image'];
}
