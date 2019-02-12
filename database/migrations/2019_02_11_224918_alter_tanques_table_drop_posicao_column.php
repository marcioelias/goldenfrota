<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTanquesTableDropPosicaoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tanques', function (Blueprint $table) {
            $table->dropColumn('posicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tanques', function (Blueprint $table) {
            $table->double('posicao', 9, 3)->after('capacidade')->default(0);
        });
    }
}
