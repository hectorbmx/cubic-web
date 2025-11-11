<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {
            // Agregar índice único para cliente_id y user_id (solo si no existe)
            if (!$this->hasIndex('cliente_user', 'cliente_user_unique')) {
                $table->unique(['cliente_id', 'user_id'], 'cliente_user_unique');
            }
            
            // Índices para búsquedas (solo si no existen)
            // if (!$this->hasIndex('cliente_user', 'cliente_user_status_index')) {
            //     $table->index('status');
            // }
            
            // if (!$this->hasIndex('cliente_user', 'cliente_user_role_index')) {
            //     $table->index('role');
            // }
        });
    }

    public function down(): void
    {
        Schema::table('cliente_user', function (Blueprint $table) {
            if ($this->hasIndex('cliente_user', 'cliente_user_unique')) {
                $table->dropUnique('cliente_user_unique');
            }
            // if ($this->hasIndex('cliente_user', 'cliente_user_status_index')) {
            //     $table->dropIndex(['status']);
            // }
            // if ($this->hasIndex('cliente_user', 'cliente_user_role_index')) {
            //     $table->dropIndex(['role']);
            // }
        });
    }
    
    private function hasIndex($table, $indexName)
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return !empty($indexes);
    }
};