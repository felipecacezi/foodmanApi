<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoItem extends Model
{
    use HasFactory;
    protected $table = 'produto_itens';

    public function vincularProdutoItens(array $arProdutoItens, int $idProduto)
    {
        try {
            $produtoItem = new ProdutoItem();

            foreach ($arProdutoItens as $chave => $item) {
                $produtoItem->item_id = $item->item_id;
                $produtoItem->produto_id = $idProduto;
                $produtoItem->qtd_item = $item->qtd_item;
                $produtoItem->save();
            }

            return [
                'status' => 201,
                'mensagem' => 'Itens vinculados com sucesso',
                'dados' => $arProdutoItens
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao vincular os itens ao produto, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
