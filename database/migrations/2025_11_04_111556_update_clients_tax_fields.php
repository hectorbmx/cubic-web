<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $taxSystems = ['RFC','VAT','RUT','NIT','CUIT','EIN','CIF','NRC','GST','OTHER'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'tax_system_desc')) {
                $table->string('tax_system_desc', 100)->nullable()->after('tax_system');
            }
        });
        $enumList = "'" . implode("','", $this->taxSystems) . "'";
        DB::statement("ALTER TABLE clientes MODIFY COLUMN tax_system ENUM($enumList) NULL");

        // 3) Crear índice único compuesto para evitar duplicados (país + tipo + id)
        //    Ojo: columnas NULL no chocarán (permitido por MySQL).
        Schema::table('clientes', function (Blueprint $table) {
            $table->unique(['country_code', 'tax_system', 'tax_id'], 'clients_country_tax_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
      public function down(): void
    {
        // Revertir: quitar índice único, devolver tax_system a string(50), quitar tax_system_desc
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropUnique('clients_country_tax_unique');
        });

        // Volver a string(50)
        DB::statement("ALTER TABLE clientes MODIFY COLUMN tax_system VARCHAR(50) NULL");

        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'tax_system_desc')) {
                $table->dropColumn('tax_system_desc');
            }
        });
    }
};
