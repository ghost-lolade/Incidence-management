<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('incidence_no');
            $table->char('pos_id');
            $table->char('serial_no');
            $table->string('branch');
            $table->string('fault_description');
            $table->string('subject');
            $table->char('vendor_id');
            $table->dateTime('log_date');
            $table->string('fromaddress');
            $table->string('status');
            $table->integer('sla_hour');
            $table->string('call_closer')->nullable();
            $table->dateTime('suspend_at');
            $table->longText('remark')->nullable();
            $table->dateTime('closure_time');
            $table->decimal('repair_amount')->default('0.0');
            $table->dateTime('reopen_at');
            $table->timestamps();
        });
    }

    // 'incidence_no','pos_id', 'serial_no', 'branch', 'fault_description', 'subject', 'vendor_id', 'log_datetime',
    //     'fromaddress', 'status', 'sla_hour', 'call_closure', 'suspend_at', 'remark', 'closure_time', 'repair_amount',
    //  'reopen_at'

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_logs');
    }
}
