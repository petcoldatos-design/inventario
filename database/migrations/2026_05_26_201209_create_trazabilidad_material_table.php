<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::create('trazabilidad_material', function (Blueprint $table) {
        $table->id();
        $table->string('codigo_paca', 50)->nullable();               // lote original
        $table->string('lote_proceso', 50)->nullable();              // lote de proceso/produccion
        $table->enum('tipo_evento', ['ingreso', 'proceso', 'produccion', 'despacho']);
        $table->dateTime('fecha_evento');
        $table->string('proveedor', 100)->nullable();
        $table->string('cliente', 150)->nullable();
        $table->string('tipo_material', 50)->nullable();
        $table->string('tipo_producto', 100)->nullable();
        $table->decimal('peso', 12, 2);
        $table->tinyInteger('puerto')->nullable();
        $table->string('linea', 100)->nullable();
        $table->string('turno', 10)->nullable();
        $table->string('operador', 100)->nullable();
        $table->string('usuario_registra', 100);
        $table->text('observaciones')->nullable();
        $table->timestamps();  // created_at = cuando se inserta

        // Índices para búsquedas rápidas
        $table->index('codigo_paca');
        $table->index('lote_proceso');
        $table->index('tipo_evento');
        $table->index('fecha_evento');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trazabilidad_material');
    }
};
