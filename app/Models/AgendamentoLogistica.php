<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendamentoLogistica extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'solicitacao_id',
        'transportador_id',
        'data_agendada',
        'status_logistica',
        'confirmacao_retirada',
        'confirmacao_entrega',
    ];

    /**
     * Define o formato da data para este modelo.
     */
    protected $casts = [
        'data_agendada' => 'datetime',
    ];
}