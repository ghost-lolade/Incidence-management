<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreventiveMaintanace extends Model
{
    //
    protected $fillable = [
        'quarter_first', 'quarter_first_date', 'quarter_second',
        'quarter_second_date', 'quarter_third', 'quarter_third_date',
        'quarter_four', 'quarter_four_date',
    ];
}
