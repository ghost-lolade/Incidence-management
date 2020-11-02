<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->index()->unsigned()->nullable();
            $table->integer('category_id')->index()->unsigned()->nullable();
            $table->integer('supplier_id')->index()->unsigned()->nullable();
			 $table->integer('brand_id')->index()->unsigned()->nullable();
            $table->string('quantity');
            $table->string('unit_price');
            $table->date('purchased_date');
            $table->timestamps();
            $table->date('delete_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
