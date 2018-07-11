<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBicosAddFieldPermiteInsercao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bicos', function (Blueprint $table) {
            $table->boolean('permite_insercao')->default(false)->after('encerrante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bicos', function (Blueprint $table) {
            $table->dropColumn('permite_insercao');
        });
    }
}
