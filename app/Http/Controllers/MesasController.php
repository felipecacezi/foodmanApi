<?php

namespace App\Http\Controllers;

use App\Models\Mesas;
use Illuminate\Http\Request;
use App\Http\Requests\deleteMesaRequest;
use App\Http\Requests\StoreMesasRequest;
use App\Http\Requests\createMesasRequest;
use App\Http\Requests\updateMesasRequest;

class MesasController extends Controller
{
    public function create(createMesasRequest $request)
    {
        try {
            $request->validated();
            $mesa = new Mesas();
            $arMesaCriada = $mesa->create(
                $request->all()
            );
            return response()
                ->json(
                    $arMesaCriada,
                    $arMesaCriada['status']
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
            $mesa = new Mesas();
            if ($request->input()) {
                $arMesas = $mesa->listMesa($request->input());
            } else {
                $arMesas = $mesa->listAll();
            }

            return response()
                ->json(
                    $arMesas,
                    $arMesas['status']
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

    public function update(updateMesasRequest $request)
    {
        try {
            $request->validated();
            $item = new Mesas();
            $arMesas = $item->updateMesa(
                $request->all()
            );
            return response()
                ->json(
                    $arMesas,
                    $arMesas['status']
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

    public function delete(deleteMesaRequest $request)
    {
        try {
            $request->validated();
            $mesa = new Mesas();
            $arMesas = $mesa->deleteMesa(
                $request->all()
            );
            return response()
                ->json(
                    $arMesas,
                    $arMesas['status']
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
