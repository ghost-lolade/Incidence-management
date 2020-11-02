<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    //
    protected $fillable = [
        'terminal_id', 'atm_serial_no','atm_name','activation_date','sol_id','address','brand','model',
        'state', 'region', 'vendor_name','vendor_id','custodian_email','custodian_phone','asset_tag_no','atm_code','timers',
        'cluster','warranty','sla_hour'

    ];
}
