<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditCurso extends FormRequest
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
            'codigo' => 'required|string|max:255',
            'departamento' => 'required|int',
            'ativo' => 'boolean',
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
            'codigo' => 'Código',
            'departamento' => 'Departamento',
            'ativo' => 'Ativo',
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
            'codigo.required' => 'O campo :attribute é obrigatório',
            'departamento.required' => 'O campo :attribute é obrigatório',
            'ativo.required' => 'O campo :attribute é obrigatório',
        ];
    }
}