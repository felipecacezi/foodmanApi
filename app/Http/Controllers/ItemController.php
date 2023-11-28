<?php

namespace App\Http\Controllers;

use App\Http\Requests\createItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

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

    public function list()
    {}

    public function update()
    {}

    public function delete()
    {}
}
