<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\createItemRequest;
use App\Http\Requests\deleteItemRequest;
use App\Http\Requests\updateItemRequest;

class ItemController extends Controller
{
    public function create(createItemRequest $request)
    {
        try {
            $request->validated();
            $item = new Item();
            $arItemCriado = $item->create(
                $request->all()
            );
            return response()
                ->json(
                    $arItemCriado,
                    $arItemCriado['status']
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
            $item = new Item();
            if ($request->input()) {
                $arItens = $item->listItem($request->input());
            } else {
                $arItens = $item->listAll();
            }

            return response()
                ->json(
                    $arItens,
                    $arItens['status']
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

    public function update(updateItemRequest $request)
    {
        try {
            $request->validated();
            $item = new Item();
            $arItens = $item->updateItem(
                $request->all()
            );
            return response()
                ->json(
                    $arItens,
                    $arItens['status']
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

    public function delete(deleteItemRequest $request)
    {
        try {
            $request->validated();
            $item = new Item();
            $arItens = $item->deleteItem(
                $request->all()
            );
            return response()
                ->json(
                    $arItens,
                    $arItens['status']
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
