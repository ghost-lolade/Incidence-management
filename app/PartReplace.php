<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartReplace extends Model
{
    protected $fillable = [
        'terminal_id','atm_name', 'part_name','price','invoice_no',
        'date','supplier_by', 'approved_by','price','user_id','delete_by','deleted_at'
    ];

    public function  user()
    {

        return $this->belongsTo('App\User');

    }
}
