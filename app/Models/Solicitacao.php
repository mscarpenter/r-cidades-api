<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'anuncio_id',
        'beneficiario_id',
        'justificativa_beneficiario',
        'status',
    ];

    /**
     * Relacionamentos
     */

    /**
     * Anúncio solicitado
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'anuncio_id');
    }

    /**
     * Usuário beneficiário que fez a solicitação
     */
    public function beneficiario()
    {
        return $this->belongsTo(User::class, 'beneficiario_id');
    }

    /**
     * Agendamento de logística (se houver)
     */
    public function agendamento()
    {
        return $this->hasOne(AgendamentoLogistica::class, 'solicitacao_id');
    }
}