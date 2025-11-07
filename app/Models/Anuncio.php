<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     * (Quais campos o formulário pode preencher)
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        // 'categoria_material_id',
        // 'banco_de_materiais_id',
        'titulo',
        'descricao',
        'quantidade',
        'condicao',
        'endereco_retirada_customizado',
        'latitude',
        'longitude',
        'status',
    ];
}