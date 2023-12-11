<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoMesas extends Model
{
    use HasFactory;
    protected $table = 'pedido_mesas';

    public function vincularPedidoMesas($arPedidoMesas)
    {
        try {
            $pedidoMesas = new PedidoMesas();
            $pedidoMesas->pedido_id = $arPedidoMesas['pedido_id'];
            $pedidoMesas->mesa_id = $arPedidoMesas['mesa_id'];
            $pedidoMesas->save();
            $arPedidoMesas['id'] = $pedidoMesas->id;

            return [
                'status' => 201,
                'mensagem' => 'Mesa vinculada ao pedido com sucesso',
                'dados' => $arPedidoMesas
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao vincular a mesa ao pedido, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
