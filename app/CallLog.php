<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CallLog extends Model
{
    //
    protected $fillable = [
        'ticket_no', 'terminal_id','user_id','fromaddress','subject','body','atm_name','error_code',
        'request_status','vendor_request_status', 'vendor_id','vendor_name','ce_name','ce_phone','sla_level','brand','call_closer_username',
        'custodian_email','custodian_phone','address', 'atm_state','region','closed_at','deleted_at','due_at','suspend_at','call_status',
        'suspend_comment','closure_comment','decline_reason','part_replaced','remark','call_confirm_username','sla_hour','mail_at'

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

    public static function insertData($data){

        $value=DB::table('call_logs')->where('terminal_id', $data['terminal_id'])->get();
        if($value->count() == 0){
            DB::table('call_logs')->insert($data);
        }
    }
}
