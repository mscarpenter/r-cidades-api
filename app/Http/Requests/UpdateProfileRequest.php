<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Apenas o próprio usuário pode atualizar seu perfil
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'tipo' => ['sometimes', 'in:doador,beneficiario,admin'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco_completo' => ['nullable', 'string', 'max:500'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2', 'uppercase'],
            'cep' => ['nullable', 'string', 'max:10'],
            'cpf_cnpj' => ['nullable', 'string', 'max:18', Rule::unique('users')->ignore($userId)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:1024'], // 1MB
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
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'tipo.in' => 'Tipo de usuário inválido.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'endereco_completo.max' => 'O endereço não pode ter mais de 500 caracteres.',
            'cidade.max' => 'A cidade não pode ter mais de 100 caracteres.',
            'estado.size' => 'O estado deve ter 2 caracteres (UF).',
            'estado.uppercase' => 'O estado deve estar em maiúsculas.',
            'cep.max' => 'O CEP não pode ter mais de 10 caracteres.',
            'cpf_cnpj.max' => 'O CPF/CNPJ não pode ter mais de 18 caracteres.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está cadastrado.',
            'avatar.image' => 'O avatar deve ser uma imagem.',
            'avatar.mimes' => 'O avatar deve ser do tipo: jpeg, jpg, png ou webp.',
            'avatar.max' => 'O avatar deve ter no máximo 1MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Converte estado para maiúsculas se fornecido
        if ($this->has('estado')) {
            $this->merge([
                'estado' => strtoupper($this->estado)
            ]);
        }
    }
}
