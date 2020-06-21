<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarefaPost extends FormRequest
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
            'nomeTarefa' => 'required|string|max:255',
            'membro' => 'nullable|int',
            'tarefaAssociada' => 'nullable|int',
            'prazo' => 'nullable|date_format:Y-m-d',
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
            'nomeTarefa' => 'Nome da tarefa',
            'membro' => 'Atribuir a',
            'tarefaAssociada' => 'Associar à tarefa',
            'prazo' => 'Data de fim prevista',
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
            'nomeTarefa.required' => 'O campo :attribute é obrigatório',
            'prazo.date_format' => 'O campo :attribute tem de ter o formato dd/mm/aaaa',
        ];
    }
}
