<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditAnoLetivo extends FormRequest
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
            'ano' => 'required|string|max:255',
            'data_inicio' => 'required|date_format:Y-m-d',
            'data_fim' => 'required|date_format:Y-m-d',
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
            'ano' => 'Ano',
            'data_inicio' => 'Data de início',
            'data_fim' => 'Data de fim',
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
            'ano.required' => 'O campo :attribute é obrigatório',
            'data_inicio.required' => 'O campo :attribute é obrigatório',
            'data_fim.required' => 'O campo :attribute é obrigatório',
            'data_inicio.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
            'data_fim.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
        ];
    }
}