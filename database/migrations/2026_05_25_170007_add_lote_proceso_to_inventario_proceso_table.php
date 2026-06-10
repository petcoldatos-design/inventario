<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventario_proceso', function (Blueprint $table) {
            $table->string('lote_proceso', 50)->unique()->after('codigo_paca');
        });
    }

    public function down()
    {
        Schema::table('inventario_proceso', function (Blueprint $table) {
            $table->dropColumn('lote_proceso');
        });
    }
};