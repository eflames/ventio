<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('sale_id')->nullable()->default(NULL);
            $table->double('amount',15,2);
            $table->text('comment')->nullable();
            $table->integer('created_by')->unsigned();
            $table->tinyInteger('closed')->nullable()->default(0);
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
        Schema::dropIfExists('loans');
    }
}
