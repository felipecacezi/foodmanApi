<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\createProdutoRequest;
use App\Http\Requests\deleteProdutoRequest;
use App\Http\Requests\updateProdutoRequest;

class ProdutosController extends Controller
{
    public function create(createProdutoRequest $request)
    {
        try {
            $request->validated();
            $produto = new Produto();
            $arResponse = $produto->create($request->all());
            return response()
                ->json(
                    $arResponse,
                    $arResponse['status']
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
            $produto = new Produto();
            if ($request->input()) {
                $arProdutos = $produto->listProduto($request->input());
            } else {
                $arProdutos = $produto->listAll();
            }

            return response()
                ->json(
                    $arProdutos,
                    $arProdutos['status']
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

    public function update(updateProdutoRequest $request)
    {
        try {
            $request->validated();
            $item = new Produto();
            $arProdutos = $item->updateProduto(
                $request->all()
            );
            return response()
                ->json(
                    $arProdutos,
                    $arProdutos['status']
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

    public function delete(deleteProdutoRequest $request)
    {
        try {
            $request->validated();
            $produto = new Produto();
            $arProdutos = $produto->deleteProduto(
                $request->all()
            );
            return response()
                ->json(
                    $arProdutos,
                    $arProdutos['status']
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
}
