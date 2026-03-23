<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_password_resets', function (Blueprint $table) {
            // rid: identificador único del intento (para el link)
            $table->uuid('id')->primary();

            // Email al que pertenece el reset
            $table->string('email')->index();

            // Hash del código OTP (6 dígitos)
            $table->string('code_hash');

            // Expiración explícita (15 minutos)
            $table->timestamp('expires_at')->index();

            // Uso único
            $table->timestamp('used_at')->nullable()->index();

            $table->timestamps();

            // Opcional: si quieres blindar contra spam por email
            // $table->unique(['email', 'used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_password_resets');
    }
};
