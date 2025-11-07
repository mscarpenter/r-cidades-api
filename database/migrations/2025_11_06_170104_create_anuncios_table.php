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
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();

            // Doador que criou o anúncio (liga na tabela 'users')
            $table->foreignId('usuario_id')->constrained('users'); 
            
            // --- Chaves estrangeiras para tabelas futuras ---
            // (Deixamos comentadas por enquanto, pois as tabelas
            // 'categorias_material' e 'bancos_de_materiais' ainda não existem)
            
            // $table->foreignId('categoria_material_id')->constrained('categorias_material');
            // $table->foreignId('banco_de_materiais_id')->nullable()->constrained('bancos_de_materiais');

            // --- Campos Principais do Anúncio ---
            $table->string('titulo');
            $table->text('descricao');
            $table->string('quantidade'); // Ex: "100 blocos", "10m²"
            $table->string('condicao'); // Ex: "Novo", "Usado", "Sobras"

            // --- Localização P2P (Se não estiver no Banco) ---
            $table->string('endereco_retirada_customizado')->nullable(); 
            $table->string('latitude')->nullable(); 
            $table->string('longitude')->nullable(); 

            // --- Controle de Fluxo (Circular UX) ---
            $table->string('status')->default('Rascunho'); // Ex: Rascunho, Publicado, Doado

            $table->timestamps(); // cria created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};