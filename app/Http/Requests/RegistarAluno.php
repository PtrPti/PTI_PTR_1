<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistarAluno extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'numero' => 'required|int',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'departamento_id' => 'required|int',
            'curso_id' => 'required|int',
            'pais_id' => 'nullable|int',
            'distrito_id' => 'nullable|int',
            'email' => 'required|email:rfc',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nome',
            'numero' => 'Número de aluno',
            'data_nascimento' => 'Data de nascimento',
            'departamento_id' => 'Departamento',
            'curso_id' => 'Curso',
            'pais_id' => 'País',
            'distrito_id' => 'Distrito',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Confimar Password',
            'cadeiras' => 'Disciplinas',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo :attribute é obrigatório',
            'numero.required' => 'O campo :attribute é obrigatório',
            'data_nascimento.required' => 'O campo :attribute é obrigatório',
            'data_nascimento.date_format' => 'O campo :attribute tem de ter o formato DD-MM-YYYY',
            'departamento_id.required' => 'O campo :attribute é obrigatório',
            'curso_id.required' => 'O campo :attribute é obrigatório',
            'email.required' => 'O campo :attribute é obrigatório',
            'email.email' => 'O campo :attribute não é um email válido',
            'password.required' => 'O campo :attribute é obrigatório',
            'password.confirmed' => 'O campo Confirmar :attribute tem de ser igual ao campo :attribute',
            'password_confirmation.required' => 'O campo :attribute é obrigatório',
            'cadeiras.required' => 'O campo :attribute é obrigatório',
            'cadeiras.min' => 'O campo :attribute tem de ter pelo menos uma opção selecionada',
        ];
    }
}