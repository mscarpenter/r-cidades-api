<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Apenas usuários autenticados podem criar solicitações
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'anuncio_id' => ['required', 'exists:anuncios,id'],
            'justificativa_beneficiario' => ['required', 'string', 'min:50', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'anuncio_id.required' => 'O anúncio é obrigatório.',
            'anuncio_id.exists' => 'O anúncio selecionado não existe.',
            'justificativa_beneficiario.required' => 'A justificativa é obrigatória.',
            'justificativa_beneficiario.min' => 'A justificativa deve ter no mínimo 50 caracteres.',
            'justificativa_beneficiario.max' => 'A justificativa não pode ter mais de 1000 caracteres.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Adiciona o ID do beneficiário (usuário autenticado)
        $this->merge([
            'beneficiario_id' => auth()->id(),
            'status' => 'pendente', // Status padrão
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Verifica se o usuário já fez uma solicitação para este anúncio
            $jaExiste = \App\Models\Solicitacao::where('anuncio_id', $this->anuncio_id)
                ->where('beneficiario_id', auth()->id())
                ->exists();

            if ($jaExiste) {
                $validator->errors()->add(
                    'anuncio_id',
                    'Você já fez uma solicitação para este anúncio.'
                );
            }

            // Verifica se o usuário não está tentando solicitar seu próprio anúncio
            $anuncio = \App\Models\Anuncio::find($this->anuncio_id);
            if ($anuncio && $anuncio->usuario_id === auth()->id()) {
                $validator->errors()->add(
                    'anuncio_id',
                    'Você não pode solicitar seu próprio anúncio.'
                );
            }
        });
    }
}
