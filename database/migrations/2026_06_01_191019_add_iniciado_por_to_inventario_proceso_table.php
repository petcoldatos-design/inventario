<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inventario_proceso', function (Blueprint $table) {
            $table->string('iniciado_por', 100)->nullable()->after('fecha_inicio');
        });
    }

    public function down()
    {
        Schema::table('inventario_proceso', function (Blueprint $table) {
            $table->dropColumn('iniciado_por');
        });
    }
};
