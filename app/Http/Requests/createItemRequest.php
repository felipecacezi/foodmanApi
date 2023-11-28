<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createItemRequest extends FormRequest
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
            'item_nome' => 'required|max:500',
            'item_unidade_medida' => 'required|max:4',
            'item_qtd_minima' => 'required',
            'item_qtd_maxima' => 'required',
            'item_ativo' => 'required',
        ];
    }
}
