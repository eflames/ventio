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
            $table->integer('client_id')->unsigned();
            $table->double('amount',15,2)->nullable()->default(0);
            $table->text('comment')->nullable();
            $table->integer('sale_status_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdade('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdade('cascade');
            $table->foreign('sale_status_id')->references('id')->on('sale_status')->onUpdade('cascade');
            $table->index('updated_at');
            $table->index('created_at');
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
