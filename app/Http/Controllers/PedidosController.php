<?php

namespace App\Http\Controllers;

use App\Models\Mesas;
use App\Models\Pedidos;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\createPedidosRequest;
use App\Http\Requests\deletePedidosRequest;
use App\Http\Requests\updatePedidosRequest;

class PedidosController extends Controller
{
    public function create(createPedidosRequest $request)
    {
        // dd($request->all());
        try {
            $request->validated();
            $pedidos = new Pedidos();
            $mesas = new Mesas();
            $produtos = new Produto();
            $arPedido = $pedidos->create(
                $request->all()
            );



            // if (
            //     !empty($arPedido['dados']['id'])
            //     && $request->mesas
            // ) {

            // }

            // if () {

            // }

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
