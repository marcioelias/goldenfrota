<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_bico')->unique();
            $table->integer('tanque_id')->unsigned();
            $table->integer('bomba_id')->unsigned();
            $table->boolean('ativo')->default(true);
            $table->foreign('tanque_id')->references('id')->on('tanques');
            $table->foreign('bomba_id')->references('id')->on('bombas');
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
        Schema::dropIfExists('bicos');
    }
}
