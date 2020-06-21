<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectPost extends FormRequest
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
            'datainicio' => 'required|date_format:Y-m-d',
            'datafim' => 'date_format:Y-m-d|after:datainicio',
            'n_elem' => 'required|int',
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
            'nome' => 'Nome do projeto',
            'datainicio' => 'Data de início',
            'datafim' => 'Data de entrega',
            'n_elem' => 'Nº de elementos',
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
            'datainicio.required' => 'O campo :attribute é obrigatório',
            'datainicio.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
            'datafim.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
            'datafim.after' => 'O campo :attribute tem de ser superior a Data de início',
            'n_elem.required' => 'O campo :attribute é obrigatório',
        ];
    }
}
