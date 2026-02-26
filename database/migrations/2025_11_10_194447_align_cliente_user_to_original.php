<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Si por algún motivo la tabla no existe aún, no hacemos nada.
        if (!Schema::hasTable('cliente_user')) {
            return;
        }

        // Detectar columnas ANTES del Schema::table
        $hasRole      = Schema::hasColumn('cliente_user', 'role');
        $hasStatus    = Schema::hasColumn('cliente_user', 'status');
        $hasInvitedAt = Schema::hasColumn('cliente_user', 'invited_at');
        $hasAccepted  = Schema::hasColumn('cliente_user', 'accepted_at');
        $hasInvBy     = Schema::hasColumn('cliente_user', 'invited_by_user_id');
        $hasCreatedAt = Schema::hasColumn('cliente_user', 'created_at');
        $hasUpdatedAt = Schema::hasColumn('cliente_user', 'updated_at');

        Schema::table('cliente_user', function (Blueprint $table) use (
            $hasRole, $hasStatus, $hasInvitedAt, $hasAccepted, $hasInvBy, $hasCreatedAt, $hasUpdatedAt
        ) {
            // columnas
            if (!$hasRole) {
                $table->string('role', 64)->nullable()->after('user_id');
            }

            if (!$hasStatus) {
                $table->string('status', 32)->default('invited')->after('role');
            }

            if (!$hasInvitedAt) {
                $table->timestamp('invited_at')->nullable()->after('status');
            }

            if (!$hasAccepted) {
                $table->timestamp('accepted_at')->nullable()->after('invited_at');
            }

            if (!$hasInvBy) {
                $table->unsignedBigInteger('invited_by_user_id')->nullable()->after('accepted_at');
            }

            // timestamps
            if (!$hasCreatedAt && !$hasUpdatedAt) {
                $table->timestamps();
            }
        });

        /**
         * IMPORTANTE:
         * - NO crear FKs aquí.
         * - NO crear unique aquí.
         * Esas definiciones deben estar en la migración que CREA la tabla.
         *
         * Si quieres index para role, lo creamos solo si no existe.
         */
        $roleIndexExists = DB::table('information_schema.STATISTICS')
            ->whereRaw('TABLE_SCHEMA = DATABASE()')
            ->where('TABLE_NAME', 'cliente_user')
            ->where('INDEX_NAME', 'cliente_user_role_index')
            ->exists();

        if (!$roleIndexExists && Schema::hasColumn('cliente_user', 'role')) {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->index('role', 'cliente_user_role_index');
            });
        }

        // FK invited_by_user_id: si existe la columna y NO existe el FK, lo creamos con nombre fijo
        // (Opcional: puedes borrarlo si prefieres 0 FKs aquí)
        $fkExists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->whereRaw('CONSTRAINT_SCHEMA = DATABASE()')
            ->where('TABLE_NAME', 'cliente_user')
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->where('CONSTRAINT_NAME', 'cliente_user_invited_by_user_id_foreign')
            ->exists();

        if (!$fkExists && Schema::hasColumn('cliente_user', 'invited_by_user_id')) {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->foreign('invited_by_user_id', 'cliente_user_invited_by_user_id_foreign')
                    ->references('id')->on('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('cliente_user')) {
            return;
        }

        // Drop FK invited_by_user_id si existe
        try {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->dropForeign('cliente_user_invited_by_user_id_foreign');
            });
        } catch (\Throwable $e) {}

        // Drop index role si existe
        try {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->dropIndex('cliente_user_role_index');
            });
        } catch (\Throwable $e) {}

        // Drop columnas si existen
        Schema::table('cliente_user', function (Blueprint $table) {
            if (Schema::hasColumn('cliente_user', 'invited_by_user_id')) $table->dropColumn('invited_by_user_id');
            if (Schema::hasColumn('cliente_user', 'accepted_at')) $table->dropColumn('accepted_at');
            if (Schema::hasColumn('cliente_user', 'invited_at')) $table->dropColumn('invited_at');
            if (Schema::hasColumn('cliente_user', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('cliente_user', 'role')) $table->dropColumn('role');

            // timestamps
            if (Schema::hasColumn('cliente_user', 'created_at')) $table->dropColumn('created_at');
            if (Schema::hasColumn('cliente_user', 'updated_at')) $table->dropColumn('updated_at');
        });
    }
};