<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');


            $table->string('customer_name');
            $table->integer('terminal_id');
            $table->integer('product_id')->index()->unsigned()->nullable();
            $table->integer('stock_id')->index()->unsigned()->nullable();
            $table->integer('category_id')->index()->unsigned()->nullable();
            $table->integer('supplier_id')->index()->unsigned()->nullable();
            $table->integer('brand_id')->index()->unsigned()->nullable();
            $table->integer('order_id')->index();
            $table->string('unit_price');
            $table->string('quantity');
            $table->string('discount');
            $table->string('product_name');
            $table->integer('tax');
            $table->string('discount');
            $table->string('sale_date');
            $table->string('total_price');
            $table->string('country');


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
        Schema::dropIfExists('sales');
    }
}
