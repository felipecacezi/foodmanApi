<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{

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

    public function test_erro_nome_vazio(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => null,
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
            ]),
        );
        $response->assertStatus(400);
    }

    public function test_unidade_medida_vazio(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => null,
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
            ]),
        );
        $response->assertStatus(400);
    }

    public function test_qtd_minima_vazio(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => null,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
            ]),
        );
        $response->assertStatus(400);
    }

    public function test_qtd_maxima_vazio(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => null,
                'item_ativo' => 1,
            ]),
        );
        $response->assertStatus(400);
    }

    public function test_ativo_vazio(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => null,
            ]),
        );
        $response->assertStatus(400);
    }

    public function test_cadastrado_sucesso(): void
    {
        $response = $this->post(
            '/api/v1/item/',
            $this->arrayCriacaoItem([
                'item_nome' => 'Alface',
                'item_unidade_medida' => 'un',
                'item_qtd_minima' => 10,
                'item_qtd_maxima' => 100,
                'item_ativo' => 1,
            ]),
        );
        $response->assertStatus(200);
    }
}