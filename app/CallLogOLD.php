<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    //
    protected $fillable = [
        'ticket_no', 'terminal_id','user_id','from','subject','body','atm_name','error_code',
        'request_status','vendor_request_status', 'vendor_id','vendor_name','ce_name','ce_phone','sla_level','brand','call_closer_username',
        'custodian_email','custodian_phone','address', 'atm_state','region','closed_at','deleted_at','due_at','suspend_at','call_status',
        'suspend_comment','closure_comment','decline_reason','part_replaced','remark','call_confirm_username','sla_hour'

    ];

    public function brand(){

        return $this->belongsTo('App\Brand', 'vendor_id');

    }
//    public function cedetail(){
//
////        return $this->hasMany('App\CustomerEngineer');
//        return $this->belongsTo('App\CustomerEngineer', 'id');
//
//    }
}
