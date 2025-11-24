<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnuncioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Verifica se o usuário é dono do anúncio
        $anuncio = $this->route('anuncio');
        return $anuncio && $anuncio->usuario_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'string', 'max:255'],
            'descricao' => ['sometimes', 'string', 'max:1000'],
            'quantidade' => ['sometimes', 'integer', 'min:1'],
            'condicao' => ['sometimes', 'in:novo,usado,danificado'],
            'endereco_retirada_customizado' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'peso_estimado_kg' => ['nullable', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:disponivel,reservado,doado,cancelado'],
            'categoria_material_id' => ['nullable', 'exists:categoria_materials,id'],
            'banco_de_materiais_id' => ['nullable', 'exists:banco_de_materials,id'],
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
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser no mínimo 1.',
            'condicao.in' => 'A condição deve ser: novo, usado ou danificado.',
            'status.in' => 'Status inválido.',
            'latitude.between' => 'A latitude deve estar entre -90 e 90.',
            'longitude.between' => 'A longitude deve estar entre -180 e 180.',
            'peso_estimado_kg.min' => 'O peso não pode ser negativo.',
            'categoria_material_id.exists' => 'A categoria selecionada não existe.',
            'banco_de_materiais_id.exists' => 'O material selecionado não existe.',
        ];
    }
}
