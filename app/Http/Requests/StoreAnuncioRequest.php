<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnuncioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Apenas usuários autenticados podem criar anúncios
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
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:1000'],
            'quantidade' => ['required', 'integer', 'min:1'],
            'condicao' => ['required', 'in:novo,usado,danificado'],
            'peso_estimado_kg' => ['nullable', 'numeric', 'min:0'],
            'endereco_retirada_customizado' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'categoria_material_id' => ['nullable', 'exists:categoria_materials,id'],
            'banco_de_materiais_id' => ['nullable', 'exists:bancos_de_materiais,id'],
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
            'titulo.required' => 'O título do anúncio é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'descricao.required' => 'A descrição do anúncio é obrigatória.',
            'descricao.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'quantidade.required' => 'A quantidade é obrigatória.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser no mínimo 1.',
            'condicao.required' => 'A condição do material é obrigatória.',
            'condicao.in' => 'A condição deve ser: novo, usado ou danificado.',
            'peso_estimado_kg.numeric' => 'O peso deve ser um número.',
            'peso_estimado_kg.min' => 'O peso não pode ser negativo.',
            'latitude.between' => 'A latitude deve estar entre -90 e 90.',
            'longitude.between' => 'A longitude deve estar entre -180 e 180.',
            'categoria_material_id.exists' => 'A categoria selecionada não existe.',
            'banco_de_materiais_id.exists' => 'O material selecionado não existe.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Adiciona o ID do usuário autenticado
        $this->merge([
            'usuario_id' => auth()->id(),
            'status' => 'disponivel', // Status padrão
        ]);
    }
}
