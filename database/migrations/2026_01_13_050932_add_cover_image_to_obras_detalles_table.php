<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obras_detalles', function (Blueprint $table) {
            // Ruta del archivo (storage/public...)
            $table->string('cover_image', 255)
                  ->nullable()
                  ->after('event_date');
        });
    }

    public function down(): void
    {
        Schema::table('obras_detalles', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });
    }
};
