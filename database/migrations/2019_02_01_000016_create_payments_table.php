<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('payment_method_id')->unsigned();
            $table->double('amount',15,2);
            $table->double('amount_bs',15,2)->nullable()->default(null);
            $table->text('comment')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales')->onUpdate('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdade('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdade('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
