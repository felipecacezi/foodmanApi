<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Http\Requests\createPedidosRequest;
use App\Http\Requests\deletePedidosRequest;
use App\Http\Requests\updatePedidosRequest;

class PedidosController extends Controller
{
    public function create(createPedidosRequest $request)
    {
        try {
            $request->validated();
            $pedidos = new Pedidos();
            $arPedido = $pedidos->create(
                $request->all()
            );
            return response()
                ->json(
                    $arPedido,
                    $arPedido['status']
                );
        } catch (\Throwable $th) {
            return response()
                ->json(
                    [
                        'status' => $th->status ?? 500,
                        'mensagem' => $th->getMessage(),
                    ],
                    $th->status ?? 500
                );
        }
    }

    public function list(Request $request)
    {
        try {
            $mesa = new Pedidos();
            if ($request->input()) {
                $arPedidos = $mesa->listMesa($request->input());
            } else {
                $arPedidos = $mesa->listAll();
            }

            return response()
                ->json(
                    $arPedidos,
                    $arPedidos['status']
                );
        } catch (\Throwable $th) {
            return response()
                ->json(
                    [
                        'status' => $th->status ?? 500,
                        'mensagem' => $th->getMessage(),
                    ],
                    $th->status ?? 500
                );
        }
    }

    public function update(updatePedidosRequest $request)
    {
        try {
            $request->validated();
            $pedido = new Pedidos();
            $arPedido = $pedido->updatePedido(
                $request->all()
            );
            return response()
                ->json(
                    $arPedido,
                    $arPedido['status']
                );
        } catch (\Throwable $th) {
            return response()
                ->json(
                    [
                        'status' => $th->status ?? 500,
                        'mensagem' => $th->getMessage(),
                    ],
                    $th->status ?? 500
                );
        }
    }

    public function delete(deletePedidosRequest $request)
    {
        try {
            $request->validated();
            $pedidos = new Pedidos();
            $arPedidos = $pedidos->deletePedido(
                $request->all()
            );
            return response()
                ->json(
                    $arPedidos,
                    $arPedidos['status']
                );
        } catch (\Throwable $th) {
            dd($th);
            return response()
                ->json(
                    [
                        'status' => $th->status ?? 500,
                        'mensagem' => $th->getMessage(),
                    ],
                    $th->status ?? 500
                );
        }
    }
}
