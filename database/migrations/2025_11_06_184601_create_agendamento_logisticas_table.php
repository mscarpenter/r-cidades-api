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
        // O Laravel usará o plural 'agendamento_logisticas'
        Schema::create('agendamento_logisticas', function (Blueprint $table) {
            $table->id();

            // --- Chaves Estrangeiras ---
            // A solicitação que foi aprovada
            $table->foreignId('solicitacao_id')->constrained('solicitacaos');
            // O transportador (que é um usuário) - pode ser nulo se for P2P
            $table->foreignId('transportador_id')->nullable()->constrained('users');

            // --- Dados da Logística ---
            $table->dateTime('data_agendada');
            $table->string('status_logistica')->default('Agendada'); // Ex: Agendada, Coletada, Entregue

            // Confirmações para o Circular UX
            $table->boolean('confirmacao_retirada')->default(false);
            $table->boolean('confirmacao_entrega')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamento_logisticas');
    }
};