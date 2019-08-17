<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfericoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afericoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('abastecimento_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('abastecimento_id')->references('id')->on('abastecimentos');
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
        Schema::dropIfExists('afericoes');
    }
}
