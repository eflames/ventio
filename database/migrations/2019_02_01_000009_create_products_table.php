<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier',255);
            $table->string('name',255);
            $table->integer('product_category_id')->unsigned();
            $table->string('description',255)->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
