<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancoDeMaterial extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'bancos_de_materiais';

    protected $fillable = [
        'nome',
        'endereco',
        'latitude',
        'longitude',
        'telefone',
        'responsavel_usuario_id',
    ];

    /**
     * Relacionamentos
     */

    /**
     * Usuário responsável pelo banco
     */
    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_usuario_id');
    }

    /**
     * Anúncios vinculados a este banco
     */
    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'banco_de_materiais_id');
    }
}
