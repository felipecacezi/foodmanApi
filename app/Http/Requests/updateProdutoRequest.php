<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'produto_nome' => 'required|max:500',
            'produto_descricao' => 'required',
            'produto_qtd_minima' => 'required',
            'produto_qtd_maxima' => 'required',
            'produto_valor' => [
                'required',
                Rule::notIn([0])
            ],
            'produto_ativo' => 'required',
            'id' => 'required',
        ];
    }
}
