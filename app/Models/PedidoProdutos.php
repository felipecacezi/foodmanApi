<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProdutos extends Model
{
    use HasFactory;
    protected $table = 'pedido_produtos';

    public function vincularPedidoProdutos($arPedidoProdutos)
    {
        try {
            $pedidoProdutos = new PedidoProdutos();
            $pedidoProdutos->pedido_id = $arPedidoProdutos['pedido_id'];
            $pedidoProdutos->mesa_id = $arPedidoProdutos['mesa_id'];
            $pedidoProdutos->save();
            $arPedidoProdutos['id'] = $pedidoProdutos->id;

            return [
                'status' => 201,
                'mensagem' => 'Produto vinculada ao pedido com sucesso',
                'dados' => $arPedidoProdutos
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao vincular o produto ao pedido, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
