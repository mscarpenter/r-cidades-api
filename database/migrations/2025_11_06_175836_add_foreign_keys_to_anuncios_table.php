<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            
            // 1. Adiciona as chaves estrangeiras (apontando para a tabela no plural)
            $table->foreignId('categoria_material_id')->nullable()->constrained('categoria_materials')->after('usuario_id');
            $table->foreignId('banco_de_materiais_id')->nullable()->constrained('bancos_de_materiais')->after('categoria_material_id');

            // 2. Adiciona a coluna para o Dashboard de Impacto
            $table->integer('peso_estimado_kg')->nullable()->after('condicao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropForeign(['categoria_material_id']);
            $table->dropForeign(['banco_de_materiais_id']);
            $table->dropColumn(['categoria_material_id', 'banco_de_materiais_id', 'peso_estimado_kg']);
        });
    }
};