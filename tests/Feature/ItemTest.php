<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/item/';

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

    public function cadastrar_novo_item(array $dados = [])
    {
        return $this->post(
            self::URL_BASE,
            $this->arrayCriacaoItem($dados),
        );
    }

    private function listar_itens(string $queryString = '')
    {
        return $this->get(
            self::URL_BASE."/".$queryString,
        );
    }

    private function atualizar_item(array $dados = [])
    {
        return $this->put(
            self::URL_BASE,
            $this->arrayAlteracaoItem($dados),
        );
    }

    private function deletar_item(int $idItem = null)
    {
        return $this->delete(
            self::URL_BASE,
            [
                'id' => $idItem
            ],
        );
    }

    public function test_cadastro_erro_campos_vazios(): void
    {
        $response = $this->cadastrar_novo_item([
            'item_nome' => null,
            'item_unidade_medida' => 'un',
            'item_qtd_minima' => 10,
            'item_qtd_maxima' => 100,
            'item_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_item([
            'item_nome' => 'Alface',
            'item_unidade_medida' => null,
            'item_qtd_minima' => 10,
            'item_qtd_maxima' => 100,
            'item_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_item([
            'item_nome' => 'Alface',
            'item_unidade_medida' => 'un',
            'item_qtd_minima' => null,
            'item_qtd_maxima' => 100,
            'item_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_item([
            'item_nome' => 'Alface',
            'item_unidade_medida' => 'un',
            'item_qtd_minima' => 10,
            'item_qtd_maxima' => null,
            'item_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_item([
            'item_nome' => 'Alface',
            'item_unidade_medida' => 'un',
            'item_qtd_minima' => 10,
            'item_qtd_maxima' => 100,
            'item_ativo' => null,
        ]);
        $response->assertStatus(422);
    }

    public function test_cadastrado_sucesso(): void
    {
        $response = $this->post(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Oregano',
                'item_unidade_medida' => 'gr',
                'item_qtd_minima' => 100,
                'item_qtd_maxima' => 1000,
                'item_ativo' => 0
            ]),
        );
        $response->assertStatus(201);
    }

    public function test_listar_todos_itens():void
    {
        $this->test_cadastrado_sucesso();

        $response = $this->get('/api/item/');
        $response->assertStatus(200);
        $this->assertCount(1, $response['dados']);
    }

    public function test_listar_um_item():void
    {
        $this->test_cadastrado_sucesso();

        $filtros = [
            'item_nome' => 'Oregano',
            'item_unidade_medida' => 'gr',
            'item_qtd_minima' => 100,
            'item_qtd_maxima' => 1000,
            'item_ativo' => 0
        ];

        foreach ($filtros as $chaveFiltro => $filtro) {
            $response = $this->get("/api/item?{$chaveFiltro}={$filtro}");
            $response->assertStatus(200);
            $this->assertCount(1, $response['dados']);
        }
    }

    public function test_alteracao_erro_nome_vazio(): void
    {

        $response = $this->put(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => null,
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
                'id' => 1,
            ]),
        );
        $response->assertStatus(422);

    }

    public function test_alteracao_erro_unidade_medida_vazio(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => null,
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
                'id' => 1,
            ]),
        );
        $response->assertStatus(422);
    }

    public function test_alteracao_erro_qtd_minima_vazio(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => null,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
                'id' => 1,
            ]),
        );
        $response->assertStatus(422);
    }

    public function test_alteracao_erro_qtd_maxima_vazio(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => null,
                'item_ativo' => 1,
                'id' => 1,
            ]),
        );
        $response->assertStatus(422);
    }

    public function test_alteracao_erro_ativo_vazio(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => null,
                'id' => 1,
            ]),
        );
        $response->assertStatus(422);
    }

    public function test_alteracao_erro_id_vazio(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayAlteracaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
                'id' => null,
            ]),
        );
        $response->assertStatus(422);
    }

    public function test_alteracao_sucesso(): void
    {
        $response = $this->put(
            '/api/item/',
            $this->arrayAlteracaoItem([
                'item_nome' => 'Tomate',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
                'id' => 1,
            ]),
        );
        $response->assertStatus(200);
    }

    public function test_delecao_erro_id_vazio(): void
    {
        $response = $this->delete(
            '/api/item/',
            [
                'id' => null,
            ],
        );
        $response->assertStatus(422);
    }

    public function test_delecao_sucesso(): void
    {
        $response = $this->delete(
            '/api/item/',
            [
                'id' => 1,
            ],
        );
        $response->assertStatus(200);
    }

}
