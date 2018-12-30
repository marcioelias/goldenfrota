<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjusteTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste_tanques', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tanque_id')->unsigned();
            $table->double('quantidade_informada', 10, 3);
            $table->double('quantidade_ajuste', 10, 3);
            $table->integer('user_id')->unsigned();
            $table->foreign('tanque_id')->references('id')->on('tanques');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('ajuste_tanques');
    }
}
