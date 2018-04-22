<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableModeloBombasCreateFieldNumBicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modelo_bombas', function (Blueprint $table) {
            $table->integer('num_bicos')->default(1)->after('modelo_bomba');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modelo_bombas', function (Blueprint $table) {
            $table->dropCollumn('num_bicos');
        });
    }
}
