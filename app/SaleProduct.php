<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    //
    protected $fillable = [
        'sale_id', 'category_id','product_id','strength_id', 'quantity','unit_price', 'sale_date','total_price',
        'rowId','tax','discount','stock_id','note','user_id','status'
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

    public function strength(){
        return $this->belongsTo('App\Strength');

    }
}
