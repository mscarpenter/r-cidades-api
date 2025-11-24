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
        'imagens',
        'quantidade',
        'condicao',
        'endereco_retirada_customizado',
        'latitude',
        'longitude',
        'peso_estimado_kg',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'imagens' => 'array',
        ];
    }

    /**
     * Relacionamentos
     */

    /**
     * Usuário que criou o anúncio (doador)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Solicitações recebidas para este anúncio
     */
    public function solicitacoes()
    {
        return $this->hasMany(Solicitacao::class, 'anuncio_id');
    }

    /**
     * Categoria do material
     */
    public function categoriaMaterial()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_material_id');
    }

    /**
     * Banco de materiais
     */
    public function bancoDeMateriais()
    {
        return $this->belongsTo(BancoDeMaterial::class, 'banco_de_materiais_id');
    }

    /**
     * Scopes de Filtro
     */

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('titulo', 'like', "%{$term}%")
                  ->orWhere('descricao', 'like', "%{$term}%");
            });
        }
    }

    public function scopeCategoria($query, $categoriaId)
    {
        if ($categoriaId) {
            $query->where('categoria_material_id', $categoriaId);
        }
    }

    public function scopeCondicao($query, $condicao)
    {
        if ($condicao) {
            $query->where('condicao', $condicao);
        }
    }

    public function scopeLocalizacao($query, $cidade, $estado)
    {
        if ($cidade) {
            $query->whereHas('usuario', function ($q) use ($cidade) {
                $q->where('cidade', 'like', "%{$cidade}%");
            });
        }
        if ($estado) {
            $query->whereHas('usuario', function ($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }
    }
}