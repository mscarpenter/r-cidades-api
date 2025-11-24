<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use App\Models\Solicitacao;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Gera e retorna as métricas do dashboard de impacto.
     */
    public function index()
    {
        // 1. Total de toneladas de material doado (Status = 'doado')
        $totalPesoDoado = Anuncio::where('status', 'doado')->sum('peso_estimado_kg');

        // 2. Total de doações/solicitações feitas
        $totalSolicitacoes = Solicitacao::count();

        // 3. Total de usuários
        $totalUsuarios = User::count();

        // 4. Total de anúncios publicados
        $totalAnuncios = Anuncio::count();

        // 5. Ranking de Doadores (Top 5)
        $ranking = User::orderBy('pontos', 'desc')
            ->where('pontos', '>', 0)
            ->take(5)
            ->get(['id', 'name', 'pontos', 'avatar']);

        return response()->json([
            'total_peso_doado_kg' => $totalPesoDoado,
            'total_solicitacoes_feitas' => $totalSolicitacoes,
            'total_usuarios_registrados' => $totalUsuarios,
            'total_anuncios_publicados' => $totalAnuncios,
            'ranking_doadores' => $ranking,
        ]);
    }
}