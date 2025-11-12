<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Primero agregar las columnas
        if (!Schema::hasColumn('cliente_user', 'status')) {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->string('status')->default('active')->after('user_id');
            });
        }

        if (!Schema::hasColumn('cliente_user', 'role')) {
            Schema::table('cliente_user', function (Blueprint $table) {
                $table->string('role')->nullable()->after('status');
            });
        }

        // Luego agregar los índices en una operación separada
        Schema::table('cliente_user', function (Blueprint $table) {
            // Agregar índice único para cliente_id y user_id (solo si no existe)
            if (!$this->hasIndex('cliente_user', 'cliente_user_unique')) {
                $table->unique(['cliente_id', 'user_id'], 'cliente_user_unique');
            }

            // Índices para búsquedas (solo si no existen)
            if (!$this->hasIndex('cliente_user', 'cliente_user_status_index')) {
                $table->index('status');
            }

            if (!$this->hasIndex('cliente_user', 'cliente_user_role_index')) {
                $table->index('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {
            // Eliminar índices primero
            if ($this->hasIndex('cliente_user', 'cliente_user_unique')) {
                $table->dropUnique('cliente_user_unique');
            }
            if ($this->hasIndex('cliente_user', 'cliente_user_status_index')) {
                $table->dropIndex('cliente_user_status_index');
            }
            if ($this->hasIndex('cliente_user', 'cliente_user_role_index')) {
                $table->dropIndex('cliente_user_role_index');
            }
        });

        // Eliminar columnas después de eliminar los índices
        Schema::table('cliente_user', function (Blueprint $table) {
            if (Schema::hasColumn('cliente_user', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('cliente_user', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
    
    private function hasIndex($table, $indexName)
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return !empty($indexes);
    }
};  