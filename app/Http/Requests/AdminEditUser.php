<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditUser extends FormRequest
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
            'nome' => 'required|string|max:255',
            'numero' => 'required|int',
            'email' => 'required|string|max:255',
            'departamento' => 'required|int',
            'curso' => 'required|int',
            'data_nascimento' => 'required|date_format:Y-m-d',
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
            'nome' => 'Nome',
            'numero' => 'Número',
            'email' => 'Email',
            'departamento' => 'Departamento',
            'curso' => 'Curso',
            'data_nascimento' => 'Data de nascimento',
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
            'nome.required' => 'O campo :attribute é obrigatório',
            'numero.required' => 'O campo :attribute é obrigatório',
            'email.required' => 'O campo :attribute é obrigatório',
            'departamento.required' => 'O campo :attribute é obrigatório',
            'curso.required' => 'O campo :attribute é obrigatório',
            'data_nascimento.required' => 'O campo :attribute é obrigatório',
            'data_nascimento.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
        ];
    }
}