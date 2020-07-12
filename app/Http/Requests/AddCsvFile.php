<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCsvFile extends FormRequest
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
            'csvfile' => 'required|file|mimes:csv,txt',
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
            'csvfile' => 'Ficheiro',
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
            'csvfile.required' => 'O campo :attribute é obrigatório',
            'csvfile.mimes' => 'O campo :attribute tem de ser um ficheiro .csv',
        ];
    }
}