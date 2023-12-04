<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Feature\ItemTest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/produto/';
    const URL_BASE_ITEM = '/api/item/';

    private function arrayCriacaoProduto(array $dados = [], array $dadosProdutoItem = []) :array
    {

        if (!empty($dadosProdutoItem)) {
            $arProduto = [
                'produto_nome' => $dados['produto_nome'] ?? null,
                'produto_descricao' => $dados['produto_descricao'] ?? null,
                'produto_qtd_minima' => $dados['produto_qtd_minima'] ?? null,
                'produto_qtd_maxima' => $dados['produto_qtd_maxima'] ?? null,
                'produto_valor' => $dados['produto_valor'] ?? null,
                'produto_ativo' => $dados['produto_ativo'] ?? null,
            ];
        } else {
            $arProduto = [
                'produto_nome' => $dados['produto_nome'] ?? null,
                'produto_descricao' => $dados['produto_descricao'] ?? null,
                'produto_qtd_minima' => $dados['produto_qtd_minima'] ?? null,
                'produto_qtd_maxima' => $dados['produto_qtd_maxima'] ?? null,
                'produto_valor' => $dados['produto_valor'] ?? null,
                'produto_ativo' => $dados['produto_ativo'] ?? null,
                'produto_item' => [
                    'produto_id' => $dadosProdutoItem['produto_id'] ?? null,
                    'item_id' => $dadosProdutoItem['item_id']  ?? null,
                    'qtd_item' => $dadosProdutoItem['qtd_item']  ?? null,
                ]
            ];
        }

        return $arProduto;
    }

    private function arrayCriacaoItem(array $dados = []) :array
    {
        return [
            'item_nome' => $dados['item_nome'] ?? null,
            'item_unidade_medida' => $dados['item_unidade_medida'] ?? null,
            'item_qtd_minima' => $dados['item_qtd_minima'] ?? null,
            'item_qtd_maxima' => $dados['item_qtd_maxima'] ?? null,
            'item_ativo' => $dados['item_ativo'] ?? null,
        ];
    }

    private function arrayAlteracaoItem(array $dados = []) :array
    {
        $dadosCriacao = $this->arrayCriacaoItem($dados);
        $dadosCriacao['id'] = $dados['id'];
        return $dadosCriacao;
    }

    private function arrayAlteracaoProduto(array $dados = []) :array
    {
        $dadosCriacao = $this->arrayCriacaoProduto($dados);
        $dadosCriacao['id'] = $dados['id'] ?? null;
        return $dadosCriacao;
    }

    private function cadastrar_novo_produto(array $dados = [])
    {
        return $this->post(
            self::URL_BASE,
            $this->arrayCriacaoProduto($dados),
        );
    }

    public function cadastrar_novo_item(array $dados = [])
    {
        return $this->post(
            self::URL_BASE_ITEM,
            $this->arrayCriacaoItem($dados),
        );
    }

    private function listar_produtos(string $queryString = '')
    {
        return $this->get(
            self::URL_BASE."/".$queryString,
        );
    }

    private function atualizar_produto(array $dados = [])
    {
        return $this->put(
            self::URL_BASE,
            $this->arrayAlteracaoProduto($dados),
        );
    }

    private function deletar_produto(int $idProduto = null)
    {
        return $this->delete(
            self::URL_BASE,
            [
                'id' => $idProduto
            ],
        );
    }

    public function test_cadastro_erro_campos_vazios(): void
    {
        $response = $this->cadastrar_novo_produto([
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
        ]);
        $response->assertStatus(422);
    }

    public function test_cadastro_sucesso():void
    {
        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(201);
    }

    public function test_cadastrar_novo_produto_com_itens_sucesso(): void
    {

        $responseItem = $this->cadastrar_novo_item([
            'item_nome' => 'Oregano',
            'item_unidade_medida' => 'gr',
            'item_qtd_minima' => 100,
            'item_qtd_maxima' => 1000,
            'item_ativo' => 0
        ]);
        $responseItem->assertStatus(201);

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
            'produto_itens' => [
                [
                    'item_id' => $responseItem['dados']['id'],
                    'qtd_item' => 2
                ]
            ]
        ]);
        $response->assertStatus(201);
    }

    public function test_listar_todos():void
    {
        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $produtos = $this->listar_produtos();

        $response->assertStatus(201);
        $this->assertCount(1, $produtos['dados']);
    }

    public function test_listar_produto()
    {
        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);

        $filtros = [
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ];

        foreach ($filtros as $chaveFiltro => $filtro) {
            $response = $this->listar_produtos("?{$chaveFiltro}={$filtro}");
            $response->assertStatus(200);
            $this->assertCount(1, $response['dados']);
        }
    }

    public function test_alterar_erro_campos_vazios()
    {
        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_nome' => 'Coca-cola',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'id' => 1,
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
        ]);
        $response->assertStatus(422);
    }

    public function test_alterar_sucesso()
    {

        $response = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);

        $response = $this->atualizar_produto([
            'id' => $response['dados']['id'],
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);
        $response->assertStatus(200);
    }

    public function test_deletar_produto()
    {
        $responseCadastro = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
        ]);

        $responseDelete = $this->deletar_produto($responseCadastro['dados']['id']);
        $responseDelete->assertStatus(200);
    }


}
