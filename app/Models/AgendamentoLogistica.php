<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendamentoLogistica extends Model
{
    use HasFactory;

    protected $table = 'agendamento_logisticas';

    protected $fillable = [
        'solicitacao_id',
        'transportador_id',
        'data_agendada',
        'status_logistica',
        'confirmacao_retirada',
        'confirmacao_entrega',
    ];

    protected $casts = [
        'data_agendada' => 'datetime',
        'confirmacao_retirada' => 'boolean',
        'confirmacao_entrega' => 'boolean',
    ];

    /**
     * Relacionamentos
     */

    public function solicitacao()
    {
        return $this->belongsTo(Solicitacao::class, 'solicitacao_id');
    }

    public function transportador()
    {
        return $this->belongsTo(User::class, 'transportador_id');
    }
}