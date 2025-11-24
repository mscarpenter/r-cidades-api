<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemAnuncioController extends Controller
{
    /**
     * Upload de imagens para um anúncio
     */
    public function upload(Request $request, Anuncio $anuncio)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($anuncio->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para adicionar imagens a este anúncio.'
            ], 403);
        }

        // Validação
        $request->validate([
            'imagens' => ['required', 'array', 'max:5'], // Máximo 5 imagens
            'imagens.*' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'], // 2MB por imagem
        ], [
            'imagens.required' => 'Você deve enviar pelo menos uma imagem.',
            'imagens.max' => 'Você pode enviar no máximo 5 imagens.',
            'imagens.*.image' => 'O arquivo deve ser uma imagem.',
            'imagens.*.mimes' => 'A imagem deve ser do tipo: jpeg, jpg, png ou webp.',
            'imagens.*.max' => 'Cada imagem deve ter no máximo 2MB.',
        ]);

        $imagensUrls = [];

        // Processa cada imagem
        foreach ($request->file('imagens') as $imagem) {
            // Gera um nome único para a imagem
            $nomeArquivo = time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();
            
            // Salva no storage/app/public/anuncios
            $path = $imagem->storeAs('anuncios', $nomeArquivo, 'public');
            
            // Adiciona a URL ao array
            $imagensUrls[] = Storage::url($path);
        }

        // Atualiza o anúncio com as novas imagens
        $imagensAtuais = $anuncio->imagens ?? [];
        $todasImagens = array_merge($imagensAtuais, $imagensUrls);
        
        $anuncio->update([
            'imagens' => $todasImagens
        ]);

        return response()->json([
            'message' => 'Imagens enviadas com sucesso!',
            'imagens' => $todasImagens
        ]);
    }

    /**
     * Remover uma imagem específica do anúncio
     */
    public function destroy(Request $request, Anuncio $anuncio)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($anuncio->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para remover imagens deste anúncio.'
            ], 403);
        }

        $request->validate([
            'imagem_url' => ['required', 'string']
        ]);

        $imagemUrl = $request->imagem_url;
        $imagensAtuais = $anuncio->imagens ?? [];

        // Remove a imagem do array
        $imagensAtualizadas = array_filter($imagensAtuais, function($url) use ($imagemUrl) {
            return $url !== $imagemUrl;
        });

        // Reindexar o array
        $imagensAtualizadas = array_values($imagensAtualizadas);

        // Tenta deletar o arquivo físico
        $path = str_replace('/storage/', '', $imagemUrl);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Atualiza o anúncio
        $anuncio->update([
            'imagens' => $imagensAtualizadas
        ]);

        return response()->json([
            'message' => 'Imagem removida com sucesso!',
            'imagens' => $imagensAtualizadas
        ]);
    }
}
