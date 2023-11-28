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
}
