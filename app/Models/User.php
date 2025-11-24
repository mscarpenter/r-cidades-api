<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. IMPORTANTE: Adicione este 'use'

class User extends Authenticatable
{
    // 2. IMPORTANTE: Adicione o 'HasApiTokens' aqui dentro
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'telefone',
        'endereco_completo',
        'cidade',
        'estado',
        'cep',
        'cpf_cnpj',
        'avatar',
        'pontos',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamentos
     */

    /**
     * Anúncios criados pelo usuário (como doador)
     */
    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'usuario_id');
    }

    /**
     * Solicitações feitas pelo usuário (como beneficiário)
     */
    public function solicitacoes()
    {
        return $this->hasMany(Solicitacao::class, 'beneficiario_id');
    }
}