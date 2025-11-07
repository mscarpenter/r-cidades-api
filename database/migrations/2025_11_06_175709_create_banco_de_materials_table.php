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
        // Cria a tabela 'bancos_de_materiais'
        Schema::create('bancos_de_materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ex: "Banco de Materiais - Norte da Ilha"
            $table->string('endereco');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('telefone')->nullable();
            
            // Um banco de materiais pode ter um Admin responsável
            $table->foreignId('responsavel_usuario_id')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos_de_materiais');
    }
};