<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEntradaTanquesAddColumnSerie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrada_tanques', function (Blueprint $table) {
            $table->string('serie')->after('nr_docto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrada_tanques', function (Blueprint $table) {
            $table->dropColumn('serie');
        });
    }
}
