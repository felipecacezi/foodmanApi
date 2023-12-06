<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    use HasFactory;
    protected $table = 'mesas';

    public function create(array $arMesa = [])
    {
        try {
            $mesa = new Mesas();
            $mesa->mesa_identificacao = $arMesa['mesa_identificacao'];
            $mesa->mesa_ativo = $arMesa['mesa_ativo'];
            $mesa->save();
            $arMesa['id'] = $mesa->id;

            return [
                'status' => 201,
                'mensagem' => 'Mesa inserida com sucesso',
                'dados' => $arMesa
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao inserir a nova mesa, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listAll():array
    {
        try {
            $arMesas = Mesas::select(
                'id',
                'mesa_identificacao',
                'mesa_ativo',
            )->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arMesas
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar as mesas, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listMesa(array $dadosFiltro):array
    {
        try {
            $queryMesas = Mesas::select(
                'id',
                'mesa_identificacao',
                'mesa_ativo',
            );

            if (isset($dadosFiltro['id'])) {
                $queryMesas->where('id', $dadosFiltro['id']);
            }

            if (isset($dadosFiltro['mesa_identificacao'])) {
                $queryMesas->where('mesa_identificacao', $dadosFiltro['mesa_identificacao']);
            }

            if (isset($dadosFiltro['mesa_ativo'])) {
                $queryMesas->where('mesa_ativo', $dadosFiltro['mesa_ativo']);
            }

            $arMesas = $queryMesas->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arMesas
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar as mesas, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function updateMesa(array $arMesa = []):array
    {
        try {
            $mesa = new Mesas();
            $mesa->find($arMesa['id']);
            $mesa->mesa_identificacao = $arMesa['mesa_identificacao'];
            $mesa->mesa_ativo = $arMesa['mesa_ativo'];
            $mesa->save();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arMesa
            ];
        } catch (\Throwable $th) {
            dd($th);
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao alterar a mesa, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function deleteMesa(array $arMesa):array
    {
        try {
            $mesa = new Mesas();
            $mesa->where('id', $arMesa['id'])
                ->update(
                    ['mesa_ativo' => 0]
                );
            return [
                'status' => 200,
                'mensagem' => 'Mesa desativada com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            dd($th);
            return [
                'status' => 500,
                'mensagem' =>'Ocorreu um erro ao inativar a mesa, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
