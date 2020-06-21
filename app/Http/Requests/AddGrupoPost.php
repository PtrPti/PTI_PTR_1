<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddGrupoPost extends FormRequest
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
            'n_grupos' => 'required|int|min:1|max:10',
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
            'n_grupos' => 'Nº de grupos',
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
            'n_grupos.required' => 'O campo :attribute é obrigatório',
            'n_grupos.min' => 'O campo :attribute não pode ser inferior a 1',
            'n_grupos.max' => 'O campo :attribute não pode ser superior a 10',
        ];
    }
}
