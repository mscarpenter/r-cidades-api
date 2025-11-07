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
        // 1. Total de toneladas de material doado
        // (Vamos assumir que 'peso_estimado_kg' está em 'anuncios'
        //  e que 'status' == 'Doado' significa que foi concluído)
        
        // $totalPesoDoado = Anuncio::where('status', 'Doado')->sum('peso_estimado_kg');
        // NOTA: Como ainda não temos o status 'Doado', vamos somar tudo por enquanto:
        $totalPesoDoado = Anuncio::sum('peso_estimado_kg');

        // 2. Total de doações/solicitações feitas
        $totalSolicitacoes = Solicitacao::count();

        // 3. Total de usuários (Beneficiários/Doadores) na plataforma
        $totalUsuarios = User::count();

        // 4. Total de anúncios publicados
        $totalAnuncios = Anuncio::count();


        // Retorna os dados prontos (KPIs) como JSON
        return response()->json([
            'total_peso_doado_kg' => $totalPesoDoado,
            'total_solicitacoes_feitas' => $totalSolicitacoes,
            'total_usuarios_registrados' => $totalUsuarios,
            'total_anuncios_publicados' => $totalAnuncios,
        ]);
    }
}