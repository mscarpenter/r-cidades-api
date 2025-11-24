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
        Schema::table('users', function (Blueprint $table) {
            // Tipo de usuário
            $table->enum('tipo', ['doador', 'beneficiario', 'admin'])->default('doador')->after('email');
            
            // Dados de contato
            $table->string('telefone', 20)->nullable()->after('tipo');
            
            // Endereço
            $table->string('endereco_completo', 500)->nullable()->after('telefone');
            $table->string('cidade', 100)->nullable()->after('endereco_completo');
            $table->string('estado', 2)->nullable()->after('cidade');
            $table->string('cep', 10)->nullable()->after('estado');
            
            // Documento
            $table->string('cpf_cnpj', 18)->nullable()->unique()->after('cep');
            
            // Avatar
            $table->string('avatar')->nullable()->after('cpf_cnpj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tipo',
                'telefone',
                'endereco_completo',
                'cidade',
                'estado',
                'cep',
                'cpf_cnpj',
                'avatar'
            ]);
        });
    }
};
