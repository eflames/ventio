<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->unique();
            $table->tinyInteger('p_sales', null, 1, 1)->nullable()->default(null);
            $table->tinyInteger('p_sell')->nullable()->default(null);
            $table->tinyInteger('p_s_inventory')->nullable()->default(null);
            $table->tinyInteger('p_e_inventory')->nullable()->default(null);
            $table->tinyInteger('p_s_clients')->nullable()->default(null);
            $table->tinyInteger('p_e_clients')->nullable()->default(null);
            $table->tinyInteger('p_s_credits')->nullable()->default(null);
            $table->tinyInteger('p_e_credits')->nullable()->default(null);
            $table->tinyInteger('p_discount')->nullable()->default(null);
            $table->tinyInteger('p_reports')->nullable()->default(null);
            $table->tinyInteger('p_users')->nullable()->default(null);
            $table->tinyInteger('p_config')->nullable()->default(null);
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('roles');
    }
}
