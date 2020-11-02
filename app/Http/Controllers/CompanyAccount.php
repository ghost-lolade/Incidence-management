<?php
/**
 * Created by PhpStorm.
 * User: Steven-UHL
 * Date: 04/08/2017
 * Time: 23:33
 */

//namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;


class CompanyAccount  extends Model
{
    protected $fillable = [
        'address', 'account'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}