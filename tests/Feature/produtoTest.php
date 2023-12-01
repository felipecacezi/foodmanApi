<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/produto/';

    private function arrayCriacaoProduto(array $dados = []) :array
    {
        return [
            'produto_nome' => $dados['produto_nome'] ?? null,
            'produto_descricao' => $dados['produto_descricao'] ?? null,
            'produto_qtd_minima' => $dados['produto_qtd_minima'] ?? null,
            'produto_qtd_maxima' => $dados['produto_qtd_maxima'] ?? null,
            'produto_valor' => $dados['produto_valor'] ?? null,
            'produto_ativo' => $dados['produto_ativo'] ?? null,
        ];
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
