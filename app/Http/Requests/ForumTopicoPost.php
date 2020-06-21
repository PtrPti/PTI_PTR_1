<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopicoPost extends FormRequest
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
            'assunto' => 'required|string',
            'mensagem' => 'required|string',
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
            'assunto' => 'Assunto',
            'mensagem' => 'Mensagem',
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
            'assunto.required' => 'O campo :attribute é obrigatório',
            'mensagem.required' => 'O campo :attribute é obrigatório',
        ];
    }
}
