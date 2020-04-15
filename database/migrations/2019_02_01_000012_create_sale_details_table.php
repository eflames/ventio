<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->double('price',15,2);
            $table->double('cost_price',15,2);
            $table->integer('qty');
            $table->integer('returned')->nullable()->default(0);
            $table->integer('gift')->nullable()->default(0);
            $table->integer('returned_reason')->nullable()->default(NULL);
            $table->integer('created_by')->unsigned();
            $table->integer('authorized_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}
