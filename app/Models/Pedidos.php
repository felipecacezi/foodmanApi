<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    public function create(array $arPedido = [])
    {
        try {
            $pedido = new Pedidos();
            $pedido->pedido_nome_cliente = $arPedido['pedido_nome_cliente'];
            $pedido->pedido_data = $arPedido['pedido_data'];
            $pedido->pedido_total_geral = converteCentavos((float)$arPedido['pedido_total_geral']);
            $pedido->pedido_status = $arPedido['pedido_status'];
            $pedido->funcionario_id = $arPedido['funcionario_id'];
            $pedido->pedido_ativo = $arPedido['pedido_ativo'];
            $pedido->save();
            $arPedido['id'] = $pedido->id;

            return [
                'status' => 201,
                'mensagem' => 'Pedido inserido com sucesso',
                'dados' => $arPedido
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao inserir a novo pedido, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listAll():array
    {
        try {
            $arPedidos = Pedidos::select(
                'id',
                'pedido_nome_cliente',
                'pedido_data',
                'pedido_total_geral',
                'pedido_status',
                'funcionario_id',
                'pedido_ativo',
            )->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arPedidos
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os pedidos, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listMesa(array $dadosFiltro):array
    {
        try {
            $queryPedidos = Pedidos::select(
                'id',
                'pedido_nome_cliente',
                'pedido_data',
                'pedido_total_geral',
                'pedido_status',
                'funcionario_id',
                'pedido_ativo',
            );

            if (isset($dadosFiltro['id'])) {
                $queryPedidos->where('id', $dadosFiltro['id']);
            }

            if (isset($dadosFiltro['pedido_nome_cliente'])) {
                $queryPedidos->where('pedido_nome_cliente', $dadosFiltro['pedido_nome_cliente']);
            }

            if (isset($dadosFiltro['pedido_data'])) {
                $queryPedidos->where('pedido_data', $dadosFiltro['pedido_data']);
            }

            if (isset($dadosFiltro['pedido_total_geral'])) {
                $queryPedidos->where('pedido_total_geral', converteCentavos((float)$dadosFiltro['pedido_total_geral']));
            }

            if (isset($dadosFiltro['pedido_status'])) {
                $queryPedidos->where('pedido_status', $dadosFiltro['pedido_status']);
            }

            if (isset($dadosFiltro['funcionario_id'])) {
                $queryPedidos->where('funcionario_id', $dadosFiltro['funcionario_id']);
            }

            if (isset($dadosFiltro['pedido_ativo'])) {
                $queryPedidos->where('pedido_ativo', $dadosFiltro['pedido_ativo']);
            }

            $arPedidos = $queryPedidos->get()->toArray();

            foreach ($arPedidos as $chavePedido => $pedido) {
                $arPedidos[$chavePedido]['pedido_total_geral'] = converteReais($pedido['pedido_total_geral']);
            }



            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arPedidos
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os pedidos, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function updatePedido(array $arPedido = []):array
    {
        try {
            $pedido = new Pedidos();
            $pedido->find($arPedido['id']);
            $pedido->pedido_nome_cliente = $arPedido['pedido_nome_cliente'];
            $pedido->pedido_data = $arPedido['pedido_data'];
            $pedido->pedido_total_geral = converteCentavos((float)$arPedido['pedido_total_geral']);
            $pedido->pedido_status = $arPedido['pedido_status'];
            $pedido->funcionario_id = $arPedido['funcionario_id'];
            $pedido->pedido_ativo = $arPedido['pedido_ativo'];
            $pedido->save();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arPedido
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao alterar o pedido, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function deletePedido($arPedido)
    {
        try {
            $pedido = new Pedidos();
            $pedido->where('id', $arPedido['id'])
                ->update(
                    ['pedido_ativo' => 0]
                );
            return [
                'status' => 200,
                'mensagem' => 'Pedido desativado com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' =>'Ocorreu um erro ao inativar o pedido, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

}
