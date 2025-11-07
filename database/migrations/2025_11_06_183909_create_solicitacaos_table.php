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
        // O Laravel usará 'solicitacaos' como plural
        Schema::create('solicitacaos', function (Blueprint $table) {
            $table->id();

            // O anúncio que está sendo solicitado
            $table->foreignId('anuncio_id')->constrained('anuncios');
            // O usuário (Beneficiário) que está solicitando
            $table->foreignId('beneficiario_id')->constrained('users');

            // Texto obrigatório do beneficiário
            $table->text('justificativa_beneficiario');
            
            // Status do fluxo
            $table->string('status')->default('Pendente'); // Ex: Pendente, Aprovada, Rejeitada

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacaos');
    }
};