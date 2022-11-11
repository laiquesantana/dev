<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'senha_atual' => ['required', new MatchOldPassword],
            'nova_senha' => ['required', 'min:8', 'string'],
            'nova_senha_confirmada' => ['same:nova_senha'],
        ];
    }

    public function messages()
    {
        return [
            'nova_senha.required' => 'A nova senha é obrigatório',
            'nova_senha.min' => 'A nova senha deve no no mínimo 8 caracters',
            'nova_senha.string' => 'A senha deve ser uma string',
            'nova_senha_confirmada.same' => 'As senhas não são iguais',
        ];
    }
}
