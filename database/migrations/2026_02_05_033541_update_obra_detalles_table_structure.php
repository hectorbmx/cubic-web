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
    Schema::table('obras_detalles', function (Blueprint $table) {
        // 1. Ponemos el body como nullable
        $table->text('body')->nullable()->change();
        
        // 2. Actualizamos los ENUMS
        // Nota: Agregamos los nuevos y mantenemos los anteriores para no romper registros viejos
        DB::statement("ALTER TABLE obras_detalles MODIFY COLUMN type ENUM(
            'note', 'progress', 'issue', 'delivery', 'inspection', 
            'Earthworks', 'Foundations', 'Roofing', 'Enclosures', 
            'Installations', 'Finishes', 'Testing', 'Handover'
        )");
    });
}

public function down()
{
    Schema::table('obras_detalles', function (Blueprint $table) {
        $table->text('body')->nullable(false)->change();
        // Opcional: Revertir el ENUM si es necesario
    });
}
};
