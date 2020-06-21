<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarefaNotaPost extends FormRequest
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
            'notaPasta' => 'nullable|int',
            'nomeNota' => 'required|string|max:255',
            'notaTexto' => 'required|string|max:4000',
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
            'notaPasta' => 'Pasta',
            'nomeNota' => 'Título',
            'notaTexto' => 'Texto',
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
            'nomeNota.required' => 'O campo :attribute é obrigatório',
            'notaTexto.required' => 'O campo :attribute é obrigatório',
        ];
    }
}
