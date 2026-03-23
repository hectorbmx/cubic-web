<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('obras_fotos', function (Blueprint $table) {
            $table->string('ruta_thumbnail', 255)
                  ->nullable()
                  ->after('ruta_archivo');
        });
    }

    public function down(): void
    {
        Schema::table('obras_fotos', function (Blueprint $table) {
            $table->dropColumn('ruta_thumbnail');
        });
    }
};
