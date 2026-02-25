<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obras_personas', function (Blueprint $table) {
            $table->id(); // BIGINT unsigned auto increment

            $table->unsignedBigInteger('obra_id');

            $table->string('nombre_completo', 255);
            $table->string('rol_empresa', 255)->nullable(); // si siempre viene, quita nullable()
            $table->string('celular', 255)->nullable();     // si siempre viene, quita nullable()
            $table->string('email', 255)->nullable();       // si siempre viene, quita nullable()

            $table->date('fecha_asignacion')->nullable();   // si siempre viene, quita nullable()

            $table->timestamps();

            // Índice + FK
            $table->index('obra_id');

            // Ajusta el nombre de la tabla destino si no es "obras"
            $table->foreign('obra_id')
                ->references('id')
                ->on('obras')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obras_personas');
    }
};