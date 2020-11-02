<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // protected $fillable = [

    //     'pos_id', 'pos_serial_no','pos_name','activation_date','sol_id','address','brand','model',
    //     'state', 'region', 'vendor_name','vendor_id','custodian_email','custodian_phone','asset_tag_no','pos_code','timers',
    //     'cluster','warranty','sla_hour','sla_level','status','created_at'

    // ];
    public function up()
    {
        Schema::create('pos_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos_id');
            $table->integer('pos_serial_no');
            $table->string('pos_name');
            $table->char('activation_date');
            $table->integer('sol_id');
            $table->char('address');
            $table->string('brand');
            $table->string('model');
            $table->string('state');
            $table->string('region');
            $table->string('vendor_name');
            $table->integer('vendor_id');
            $table->integer('custodian_phone');
            $table->char('pos_code');
            $table->string('sla_hour');
            $table->string('sla_level');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_datas');
    }
}
