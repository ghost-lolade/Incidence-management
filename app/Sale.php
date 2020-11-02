<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'patient_id', 'tax', 'grand_price', 'user_id','status', 'sale_date', 'note', 'status_id', 'is_status','insurance_id','amount_deposit'
    ];


    public function supplier(){
        return $this->belongsTo('App\Supplier');

    }

    public function category(){
        return $this->belongsTo('App\Category');

    }

    public function product(){
        return $this->belongsTo('App\Product');

    }

    public function brand(){
        return $this->belongsTo('App\Brand');

    }public function patient(){
        return $this->belongsTo('App\Patient');

    }
    public function insurance(){
        return $this->belongsTo('App\Insurance');

    }

    public function saleproduct(){
        return $this->hasMany('App\SaleProduct');

    }

}
