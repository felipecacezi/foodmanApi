<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/pedido/';
    const URL_BASE_MESA = '/api/mesa/';
    const URL_BASE_PRODUTO = '/api/produto/';
    const URL_BASE_ITEM = '/api/item/';

    private function arrayCriacaoMesa(array $dados = []) :array
    {
        return [
            'mesa_identificacao' => $dados['mesa_identificacao'] ?? null,
            'mesa_ativo' => $dados['mesa_ativo'] ?? null,
        ];
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

    public function arrayCriacaoProduto(array $dados = []) :array
    {
        $arProduto = [
            'produto_nome' => $dados['produto_nome'] ?? null,
            'produto_descricao' => $dados['produto_descricao'] ?? null,
            'produto_qtd_minima' => $dados['produto_qtd_minima'] ?? null,
            'produto_qtd_maxima' => $dados['produto_qtd_maxima'] ?? null,
            'produto_valor' => $dados['produto_valor'] ?? null,
            'produto_ativo' => $dados['produto_ativo'] ?? null,
            'produto_itens' => $dados['produto_itens'] ?? [],
        ];

        return $arProduto;
    }

    private function arrayCriacaoPedido(array $dados = []) :array
    {
        return [
            'pedido_nome_cliente' => $dados['pedido_nome_cliente'] ?? null,
            'pedido_data' => $dados['pedido_data'] ?? null,
            'pedido_total_geral' => $dados['pedido_total_geral'] ?? null,
            'pedido_status' => $dados['pedido_status'] ?? null,
            'funcionario_id' => $dados['funcionario_id'] ?? null,
            'pedido_ativo' => $dados['pedido_ativo'] ?? null,
            'mesas' => $dados['mesas'] ?? [],
            'produtos' => $dados['produtos'] ?? [],
        ];
    }

    private function arrayAlteracaoPedido(array $dados = []) :array
    {
        $dadosCriacao = $this->arrayCriacaoPedido($dados);
        $dadosCriacao['id'] = $dados['id'];
        return $dadosCriacao;
    }

    private function cadastrar_novo_pedido(array $dados = [])
    {
        return $this->post(
            self::URL_BASE,
            $this->arrayCriacaoPedido($dados),
        );
    }

    private function cadastrar_novo_produto(array $dados = [])
    {
        return $this->post(
            self::URL_BASE_PRODUTO,
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

    public function cadastrar_nova_mesa(array $dados = [])
    {
        return $this->post(
            self::URL_BASE_MESA,
            $this->arrayCriacaoMesa($dados),
        );
    }

    private function listar_pedidos(string $queryString = '')
    {
        return $this->get(
            self::URL_BASE.$queryString,
        );
    }

    private function atualizar_pedido(array $dados = [])
    {
        return $this->put(
            self::URL_BASE,
            $this->arrayAlteracaoPedido($dados),
        );
    }

    private function deletar_pedido(int $idPedido = null)
    {
        return $this->delete(
            self::URL_BASE,
            [
                'id' => $idPedido
            ],
        );
    }

    public function test_cadastro_erro_campos_vazios()
    {
        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => null,
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => null,
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => null,
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => null,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => null,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => null,
        ]);
        $response->assertStatus(422);
    }

    public function test_cadastro_sucesso()
    {

        $responseItem = $this->post(
            self::URL_BASE_ITEM,
            $this->arrayCriacaoItem([
                'item_nome' => 'Oregano',
                'item_unidade_medida' => 'gr',
                'item_qtd_minima' => 100,
                'item_qtd_maxima' => 1000,
                'item_ativo' => 0
            ]),
        );
        $responseItem->assertStatus(201);

        $responseProduto = $this->cadastrar_novo_produto([
            'produto_nome' => 'Coca-cola',
            'produto_descricao' => 'Coca-cola lata 250ml',
            'produto_qtd_minima' => 10,
            'produto_qtd_maxima' => 100,
            'produto_valor' => 5000,
            'produto_ativo' => 1,
            'produto_itens' => [
                [
                    'item_id' => $responseItem['dados']['id'],
                    'qtd_item' => 1
                ],
                [
                    'item_id' => $responseItem['dados']['id'],
                    'qtd_item' => 2
                ]
            ]
        ]);
        $responseProduto->assertStatus(201);

        $responseMesa = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa->assertStatus(201);

        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
            'mesas' => [
                ['mesa_id' => $responseMesa['dados']['id']]
            ],
            'produtos' => [
                ['produto_id' => $responseProduto['dados']['id']]
            ]
        ]);
        $response->assertStatus(201);



    }



    public function test_listar_todos():void
    {
        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(201);
        $pedidos = $this->listar_pedidos();
        $this->assertCount(1, $pedidos['dados']);
    }

    public function test_listar_filtro():void
    {
        $responsePedido1 = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $responsePedido1->assertStatus(201);

        $responsePedido2 = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Antonio',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '50,00',
            'pedido_status' => 1,
            'funcionario_id' => 2,
            'pedido_ativo' => 1,
        ]);
        $responsePedido2->assertStatus(201);

        $pedidos = $this->listar_pedidos("?id={$responsePedido1['dados']['id']}");
        $this->assertCount(1, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?pedido_nome_cliente={$responsePedido2['dados']['pedido_nome_cliente']}");
        $this->assertCount(1, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?pedido_data={$responsePedido2['dados']['pedido_data']}");
        $this->assertCount(2, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?pedido_total_geral={$responsePedido1['dados']['pedido_total_geral']}");
        $this->assertCount(1, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?pedido_status={$responsePedido1['dados']['pedido_status']}");
        $this->assertCount(2, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?funcionario_id={$responsePedido2['dados']['funcionario_id']}");
        $this->assertCount(1, $pedidos['dados']);

        $pedidos = $this->listar_pedidos("?pedido_ativo={$responsePedido2['dados']['pedido_ativo']}");
        $this->assertCount(2, $pedidos['dados']);
    }

    public function test_alteracao_erro_nome_vazio(): void
    {

        $responsePedido = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $responsePedido->assertStatus(201);

        $response = $this->atualizar_pedido([
            'id' => null,
            'pedido_nome_cliente' => null,
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => null,
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => null,
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => null,
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => null,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => null,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => null,
        ]);
        $response->assertStatus(422);

    }

    public function test_alteracao_sucesso(): void
    {

        $responsePedido = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $responsePedido->assertStatus(201);

        $response = $this->atualizar_pedido([
            'id' => $responsePedido['dados']['id'],
            'pedido_nome_cliente' => 'Josias',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
        ]);
        $response->assertStatus(200);

    }

    public function test_deletar_produto()
    {
        $responsePedido = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1
        ]);
        $responsePedido->assertStatus(201);

        $responseDelete = $this->deletar_pedido($responsePedido['dados']['id']);
        $responseDelete->assertStatus(200);
    }

}
