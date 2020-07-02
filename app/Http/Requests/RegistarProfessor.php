<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistarProfessor extends FormRequest
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
            'nameProf' => 'required|string|max:255',
            'numeroProf' => 'required|int',
            'data_nascimentoProf' => 'required|date_format:Y-m-d',
            'departamento_idProf' => 'required|int',
            'curso_idProf' => 'nullable|int',
            'pais_idProf' => 'nullable|int',
            'distrito_idProf' => 'nullable|int',
            'emailProf' => 'required|email:rfc',
            'passwordProf' => 'required|string|min:6|confirmed',
            'passwordProf_confirmation' => 'required|string',
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
            'nameProf' => 'Nome',
            'numeroProf' => 'Número de aluno',
            'data_nascimentoProf' => 'Data de nascimento',
            'departamento_idProf' => 'Departamento',
            'curso_idProf' => 'Curso',
            'pais_idProf' => 'País',
            'distrito_idProf' => 'Distrito',
            'emailProf' => 'Email',
            'passwordProf' => 'Password',
            'passwordProf_confirmation' => 'Confimar Password',
            'cadeirasProf' => 'Disciplinas',
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
            'nameProf.required' => 'O campo :attribute é obrigatório',
            'numeroProf.required' => 'O campo :attribute é obrigatório',
            'data_nascimentoProf.required' => 'O campo :attribute é obrigatório',
            'data_nascimentoProf.date_format' => 'O campo :attribute tem de ter o formato DD-MM-YYYY',
            'departamento_idProf.required' => 'O campo :attribute é obrigatório',
            'curso_idProf.required' => 'O campo :attribute é obrigatório',
            'emailProf.required' => 'O campo :attribute é obrigatório',
            'emailProf.email' => 'O campo :attribute não é um email válido',
            'passwordProf.required' => 'O campo :attribute é obrigatório',
            'passwordProf.confirmed' => 'O campo Confirmar :attribute tem de ser igual ao campo :attribute',
            'passwordProf_confirmation.required' => 'O campo :attribute é obrigatório',
            'cadeirasProf.required' => 'O campo :attribute é obrigatório',
            'cadeirasProf.min' => 'O campo :attribute tem de ter pelo menos uma opção selecionada',
        ];
    }
}