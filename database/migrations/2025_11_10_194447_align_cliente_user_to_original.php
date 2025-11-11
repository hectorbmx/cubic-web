<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {
            // 1) Cambiar 'status' de tinyint a string (si existe y es numérico)
            if (Schema::hasColumn('cliente_user', 'status')) {
                // Requiere doctrine/dbal para ->change()
                $table->string('status', 32)->default('invited')->change();
            } else {
                $table->string('status', 32)->default('invited');
            }

            // 2) Agregar 'role' si no existe
            if (!Schema::hasColumn('cliente_user', 'role')) {
                $table->string('role', 64)->nullable()->after('user_id');
            }

            // 3) Campos de invitación/aceptación
            if (!Schema::hasColumn('cliente_user', 'invited_at')) {
                $table->timestamp('invited_at')->nullable()->after('role');
            }
            if (!Schema::hasColumn('cliente_user', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('invited_at');
            }
            if (!Schema::hasColumn('cliente_user', 'invited_by_user_id')) {
                $table->unsignedBigInteger('invited_by_user_id')->nullable()->after('accepted_at');
            }

            // 4) Índices: único (cliente_id, user_id) y de búsqueda
            // $table->unique(['cliente_id', 'user_id'], 'cliente_user_unique');

            // $table->index('status', 'cliente_user_status_index');
            $table->index('role', 'cliente_user_role_index');

            // 5) FK opcionales (ajusta nombres de tablas/ids si difieren)
            // Evita error si ya existen
            if (! $this->hasForeign('cliente_user', 'cliente_user_invited_by_user_id_foreign')) {
                $table->foreign('invited_by_user_id')
                      ->references('id')->on('users')
                      ->nullOnDelete();
            }
            if (! $this->hasForeign('cliente_user', 'cliente_user_user_id_foreign')) {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            }
            if (! $this->hasForeign('cliente_user', 'cliente_user_cliente_id_foreign')) {
                $table->foreign('cliente_id')->references('id')->on('clientes')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {
            // Quitar FKs si existen
            $this->dropFkIfExists($table, 'cliente_user_invited_by_user_id_foreign');
            $this->dropFkIfExists($table, 'cliente_user_user_id_foreign');
            $this->dropFkIfExists($table, 'cliente_user_cliente_id_foreign');

            // Quitar índices
            // $this->dropIndexIfExists($table, 'cliente_user_unique');
            $this->dropIndexIfExists($table, 'cliente_user_status_index');
            $this->dropIndexIfExists($table, 'cliente_user_role_index');

            // Quitar columnas agregadas (deja 'status' como estaba)
            if (Schema::hasColumn('cliente_user', 'invited_by_user_id')) {
                $table->dropColumn('invited_by_user_id');
            }
            if (Schema::hasColumn('cliente_user', 'accepted_at')) {
                $table->dropColumn('accepted_at');
            }
            if (Schema::hasColumn('cliente_user', 'invited_at')) {
                $table->dropColumn('invited_at');
            }
            if (Schema::hasColumn('cliente_user', 'role')) {
                $table->dropColumn('role');
            }

            // Revertir 'status' a tinyint(3) si lo deseas (opcional)
            // Requiere doctrine/dbal para change()
            // $table->unsignedTinyInteger('status')->default(1)->change();
        });
    }

    private function hasForeign(string $table, string $fkName): bool
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $doctrineTable = $sm->listTableDetails($table);
        return $doctrineTable->hasForeignKey($fkName);
    }

    private function dropFkIfExists(Blueprint $table, string $fkName): void
    {
        try { $table->dropForeign($fkName); } catch (\Throwable $e) {}
    }

    private function dropIndexIfExists(Blueprint $table, string $indexName): void
    {
        try { $table->dropIndex($indexName); } catch (\Throwable $e) {}
    }
};
