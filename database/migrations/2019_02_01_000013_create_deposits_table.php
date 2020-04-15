<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('sale_id')->nullable()->default(NULL);
            $table->double('amount',15,2);
            $table->text('comment')->nullable();
            $table->tinyInteger('claimed')->nullable()->default(NULL);
            $table->integer('claimed_in_sale_id')->nullable()->default(NULL);
            $table->integer('created_by')->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('deposits');
    }
}
