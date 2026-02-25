<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {

            // role
            if (!Schema::hasColumn('cliente_user', 'role')) {
                $table->string('role', 64)->nullable()->after('user_id');
            }

            // status
            if (!Schema::hasColumn('cliente_user', 'status')) {
                $table->string('status', 32)->default('invited')->after('role');
            } else {
                // Si en algún punto quieres convertir tinyint -> string, eso requiere doctrine/dbal.
                // En instalación nueva normalmente ya lo creas correcto desde la migración original del pivot.
            }

            // invitaciones
            if (!Schema::hasColumn('cliente_user', 'invited_at')) {
                $table->timestamp('invited_at')->nullable()->after('status');
            }

            if (!Schema::hasColumn('cliente_user', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('invited_at');
            }

            if (!Schema::hasColumn('cliente_user', 'invited_by_user_id')) {
                $table->unsignedBigInteger('invited_by_user_id')->nullable()->after('accepted_at');
            }

            // timestamps (solo si tu relación usa withTimestamps())
            if (!Schema::hasColumn('cliente_user', 'created_at') && !Schema::hasColumn('cliente_user', 'updated_at')) {
                $table->timestamps();
            }

            // índice role (en fresh no habrá duplicado)
            $table->index('role', 'cliente_user_role_index');

            // FKs (en fresh no habrá duplicados)
            // OJO: esto asume que el pivot tiene cliente_id y user_id
            $table->foreign('cliente_id')->references('id')->on('clientes')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('invited_by_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {

            // drop FKs primero
            try { $table->dropForeign(['invited_by_user_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['cliente_id']); } catch (\Throwable $e) {}

            // drop index
            try { $table->dropIndex('cliente_user_role_index'); } catch (\Throwable $e) {}

            // drop columnas
            if (Schema::hasColumn('cliente_user', 'invited_by_user_id')) $table->dropColumn('invited_by_user_id');
            if (Schema::hasColumn('cliente_user', 'accepted_at')) $table->dropColumn('accepted_at');
            if (Schema::hasColumn('cliente_user', 'invited_at')) $table->dropColumn('invited_at');
            if (Schema::hasColumn('cliente_user', 'role')) $table->dropColumn('role');

            // timestamps: solo si existen
            if (Schema::hasColumn('cliente_user', 'created_at')) $table->dropColumn('created_at');
            if (Schema::hasColumn('cliente_user', 'updated_at')) $table->dropColumn('updated_at');
        });
    }
};