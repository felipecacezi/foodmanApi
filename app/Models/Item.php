<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';

    public function create(array $arItem):array
    {

        try {
            $item = new Item();
            $item->item_nome = $arItem['item_nome'];
            $item->item_unidade_medida = $arItem['item_unidade_medida'];
            $item->item_qtd_minima = $arItem['item_qtd_minima'];
            $item->item_qtd_maxima = $arItem['item_qtd_maxima'];
            $item->item_ativo = $arItem['item_ativo'];
            $item->save();

            return [
                'status' => 201,
                'mensagem' => 'Item inserido com sucesso',
                'dados' => []
            ];

        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao inserir o novo item, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listAll():array
    {
        try {
            $arItens = Item::select(
                'id',
                'item_nome',
                'item_unidade_medida',
                'item_qtd_minima',
                'item_qtd_maxima',
                'item_ativo'
            )->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arItens
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os itens, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listItem(array $dadosFiltro = []):array
    {
        try {
            $queryItens = Item::select(
                'id',
                'item_nome',
                'item_unidade_medida',
                'item_qtd_minima',
                'item_qtd_maxima',
                'item_ativo'
            );

            if (isset($dadosFiltro['item_nome'])) {
                $queryItens->where('item_nome', $dadosFiltro['item_nome']);
            }

            if (isset($dadosFiltro['item_unidade_medida'])) {
                $queryItens->where('item_unidade_medida', $dadosFiltro['item_unidade_medida']);
            }

            if (isset($dadosFiltro['item_qtd_minima'])) {
                $queryItens->where('item_qtd_minima', $dadosFiltro['item_qtd_minima']);
            }

            if (isset($dadosFiltro['item_qtd_maxima'])) {
                $queryItens->where('item_qtd_maxima', $dadosFiltro['item_qtd_maxima']);
            }

            if (isset($dadosFiltro['item_ativo'])) {
                $queryItens->where('item_ativo', $dadosFiltro['item_ativo']);
            }

            if (isset($dadosFiltro['id'])) {
                $queryItens->where('id', $dadosFiltro['id']);
            }

            $arItens = $queryItens->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arItens
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os itens, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function updateItem(array $arItem):array
    {
        try {
            $item = new Item();
            $item->find($arItem['id']);
            $item->item_nome = $arItem['item_nome'];
            $item->item_unidade_medida = $arItem['item_unidade_medida'];
            $item->item_qtd_minima = $arItem['item_qtd_minima'];
            $item->item_qtd_maxima = $arItem['item_qtd_maxima'];
            $item->item_ativo = $arItem['item_ativo'];
            $item->save();

            return [
                'status' => 200,
                'mensagem' => 'Item alterado com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao alterar o item, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function deleteItem(array $arItem):array
    {
        try {
            $item = new Item();
            $item->where('id', $arItem['id'])
                ->update(
                    ['item_ativo' => 0]
                );
            return [
                'status' => 200,
                'mensagem' => 'Item desativado com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' =>'Ocorreu um erro ao inativar o item, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
