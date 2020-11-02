<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosLog extends Model
{
    //
    protected $fillable = [

        'incidence_no','pos_id', 'serial_no', 'branch', 'fault_description', 'subject', 'vendor_id', 'log_date',
        'fromaddress', 'status', 'sla_hour', 'call_closer', 'suspend_at', 'remark', 'closure_time', 'repair_amount', 'reopen_at'

    ];

    public static function insertData($data){

        $value=DB::table('pos_logs')->where('pos_id', $data['pos_id'])->get();
        if($value->count() == 0){
            DB::table('pos_logs')->insert($data);
        }
    }
}
