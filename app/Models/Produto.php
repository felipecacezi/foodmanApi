<?php

namespace App\Models;

use App\Models\ProdutoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produtos';

    public function create(array $arProduto):array
    {
        try {

            $produto = new Produto();
            $produtoItem = new ProdutoItem();
            $produto->produto_nome = $arProduto['produto_nome'];
            $produto->produto_descricao = $arProduto['produto_descricao'];
            $produto->produto_qtd_minima = $arProduto['produto_qtd_minima'];
            $produto->produto_qtd_maxima = $arProduto['produto_qtd_maxima'];
            $produto->produto_valor = $arProduto['produto_valor'];
            $produto->produto_ativo = $arProduto['produto_ativo'];
            $produto->save();
            $arProduto['id'] = $produto->id;

            if (
                isset($arProduto['produto_itens'])
                && !empty($arProduto['produto_itens'])
            ) {
                $produtoItem->vincularProdutoItens(
                    $arProduto['produto_itens'],
                    (int)$arProduto['id']
                );
            }

            return [
                'status' => 201,
                'mensagem' => 'Produto inserido com sucesso',
                'dados' => $arProduto
            ];

        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao inserir o novo produto, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listAll():array
    {
        try {
            $arProdutos = Produto::select(
                'id',
                'produto_nome',
                'produto_descricao',
                'produto_qtd_minima',
                'produto_qtd_maxima',
                'produto_valor',
                'produto_ativo'
            )->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arProdutos
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os produtos, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function listProduto(array $dadosFiltro):array
    {
        try {
            $queryProdutos = Produto::select(
                'id',
                'produto_nome',
                'produto_descricao',
                'produto_qtd_minima',
                'produto_qtd_maxima',
                'produto_valor',
                'produto_ativo'
            );

            if (isset($dadosFiltro['produto_nome'])) {
                $queryProdutos->where('produto_nome', $dadosFiltro['produto_nome']);
            }

            if (isset($dadosFiltro['produto_descricao'])) {
                $queryProdutos->where('produto_descricao', $dadosFiltro['produto_descricao']);
            }

            if (isset($dadosFiltro['produto_qtd_minima'])) {
                $queryProdutos->where('produto_qtd_minima', $dadosFiltro['produto_qtd_minima']);
            }

            if (isset($dadosFiltro['produto_qtd_maxima'])) {
                $queryProdutos->where('produto_qtd_maxima', $dadosFiltro['produto_qtd_maxima']);
            }

            if (isset($dadosFiltro['produto_valor'])) {
                $queryProdutos->where('produto_valor', $dadosFiltro['produto_valor']);
            }

            if (isset($dadosFiltro['produto_ativo'])) {
                $queryProdutos->where('produto_ativo', $dadosFiltro['produto_ativo']);
            }

            if (isset($dadosFiltro['id'])) {
                $queryProdutos->where('id', $dadosFiltro['id']);
            }

            $arProdutos = $queryProdutos->get()->toArray();

            return [
                'status' => 200,
                'mensagem' => '',
                'dados' => $arProdutos
            ];
        } catch (\Throwable $th) {
            dd($th);
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao buscar os produtos, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function updateProduto(array $arProduto):array
    {
        try {
            $produto = new Produto();
            $produto->find($arProduto['id']);
            $produto->produto_nome = $arProduto['produto_nome'];
            $produto->produto_descricao = $arProduto['produto_descricao'];
            $produto->produto_qtd_minima = $arProduto['produto_qtd_minima'];
            $produto->produto_qtd_maxima = $arProduto['produto_qtd_maxima'];
            $produto->produto_valor = $arProduto['produto_valor'];
            $produto->produto_ativo = $arProduto['produto_ativo'];
            $produto->save();

            return [
                'status' => 200,
                'mensagem' => 'Produto alterado com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' => 'Ocorreu um erro ao alterar o produto, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }

    public function deleteProduto($arProduto)
    {
        try {
            $produto = new Produto();
            $produto->where('id', $arProduto['id'])
                ->update(
                    ['produto_ativo' => 0]
                );
            return [
                'status' => 200,
                'mensagem' => 'Produto desativado com sucesso',
                'dados' => []
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 500,
                'mensagem' =>'Ocorreu um erro ao inativar o produto, entre em contato com o suporte.',
                'dados' => []
            ];
        }
    }
}
