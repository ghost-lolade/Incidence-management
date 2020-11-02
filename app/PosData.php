<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PosData extends Model
{
    //
    protected $fillable = [

        'pos_id', 'pos_serial_no','pos_name','activation_date','sol_id','address','brand','model',
        'state', 'region', 'vendor_name','vendor_id','custodian_email','custodian_phone','asset_tag_no','pos_code','timers',
        'cluster','warranty','sla_hour','sla_level','status','created_at'

    ];

    public static function insertData($data){

        $value=DB::table('pos_datas')->where('pos_id', $data['pos_id'])->get();
        if($value->count() == 0){
            DB::table('pos_datas')->insert($data);
        }
    }
}
