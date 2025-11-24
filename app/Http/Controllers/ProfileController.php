<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Exibir o perfil do usuário autenticado
     */
    public function show()
    {
        $user = auth()->user();
        
        // Carrega relacionamentos úteis
        $user->load(['anuncios', 'solicitacoes']);
        
        // Adiciona estatísticas
        $user->stats = [
            'total_anuncios' => $user->anuncios()->count(),
            'anuncios_ativos' => $user->anuncios()->where('status', 'disponivel')->count(),
            'total_solicitacoes' => $user->solicitacoes()->count(),
            'solicitacoes_aprovadas' => $user->solicitacoes()->where('status', 'aprovada')->count(),
        ];

        return response()->json($user);
    }

    /**
     * Atualizar o perfil do usuário autenticado
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        // Se houver upload de avatar
        if ($request->hasFile('avatar')) {
            // Remove avatar antigo se existir
            if ($user->avatar) {
                $oldPath = str_replace('/storage/', '', $user->avatar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Salva novo avatar
            $avatar = $request->file('avatar');
            $nomeArquivo = 'avatar_' . $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $nomeArquivo, 'public');
            $data['avatar'] = Storage::url($path);
        }

        // Atualiza os dados
        $user->update($data);

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'user' => $user
        ]);
    }

    /**
     * Atualizar senha do usuário
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'new_password.confirmed' => 'As senhas não coincidem.',
        ]);

        $user = auth()->user();

        // Verifica se a senha atual está correta
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta.',
                'errors' => [
                    'current_password' => ['A senha atual está incorreta.']
                ]
            ], 422);
        }

        // Atualiza a senha
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Senha atualizada com sucesso!'
        ]);
    }

    /**
     * Remover avatar do usuário
     */
    public function removeAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            // Remove o arquivo
            $path = str_replace('/storage/', '', $user->avatar);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            // Atualiza o banco
            $user->update(['avatar' => null]);

            return response()->json([
                'message' => 'Avatar removido com sucesso!'
            ]);
        }

        return response()->json([
            'message' => 'Nenhum avatar para remover.'
        ], 404);
    }

    /**
     * Listar anúncios do usuário autenticado
     */
    public function meusAnuncios()
    {
        $anuncios = auth()->user()
            ->anuncios()
            ->with('categoriaMaterial', 'solicitacoes')
            ->latest()
            ->get();

        return response()->json($anuncios);
    }
}
