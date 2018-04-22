<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBombasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bombas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao_bomba')->unique();
            $table->integer('tipo_bomba_id')->unsigned();
            $table->integer('modelo_bomba_id')->unsigned();
            $table->boolean('ativo')->default(true);
            $table->foreign('tipo_bomba_id')->references('id')->on('tipo_bombas');
            $table->foreign('modelo_bomba_id')->references('id')->on('modelo_bombas');
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
        Schema::dropIfExists('bombas');
    }
}
