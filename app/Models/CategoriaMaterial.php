<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    /**
     * Relacionamentos
     */

    /**
     * Anúncios desta categoria
     */
    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'categoria_material_id');
    }
}
