<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditCadeira extends FormRequest
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
            'ano' => 'required|string|max:255',
            'curso' => 'required|int',
            'ano_letivo' => 'required|int',
            'semestre' => 'required|int',
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
            'ano' => 'Ano',
            'semestre' => 'Semestre',
            'ano_letivo' => 'Ano letivo',
            'curso' => 'Curso',
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
            'ano.required' => 'O campo :attribute é obrigatório',
            'semestre.required' => 'O campo :attribute é obrigatório',
            'ano_letivo.required' => 'O campo :attribute é obrigatório',
            'curso.required' => 'O campo :attribute é obrigatório',
        ];
    }
}