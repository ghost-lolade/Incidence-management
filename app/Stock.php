<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $table = 'stocks';

    protected $fillable = [
        'product_id', 'category_id', 'supplier_id', 'brand_id', 'quantity','unit_price', 'purchased_date', 'drugpresentation_id',
        'strength_id', 'purchased_price', 'sales_price', 'expired_date'
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

    }

    public function strength(){

        return $this->belongsTo('App\Strength');

    }
    public function drugpresentation(){

        return $this->belongsTo('App\Drugpresentation');

    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
