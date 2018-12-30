<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaTanqueItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_tanque_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entrada_tanque_id')->unsigned();
            $table->integer('tanque_id')->unsigned();
            $table->double('quantidade', 10, 3);
            $table->double('valor_unitario', 10, 3);
            $table->foreign('entrada_tanque_id')->references('id')->on('entrada_tanques')->onDelete('cascade');
            $table->foreign('tanque_id')->references('id')->on('tanques');
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
        Schema::dropIfExists('entrada_tanque_items');
    }
}
