<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePedidosRequest extends FormRequest
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
            'id' => 'required',
            'pedido_nome_cliente' => 'required|max:500',
            'pedido_data' => 'required|date',
            'pedido_total_geral' => 'required',
            'pedido_status' => 'required',
            'funcionario_id' => 'required',
            'pedido_ativo' => 'required',
        ];
    }
}
