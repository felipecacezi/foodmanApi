<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/pedido/';

    private function arrayCriacaoPedido(array $dados = []) :array
    {
        return [
            'pedido_nome_cliente' => $dados['pedido_nome_cliente'] ?? null,
            'pedido_data' => $dados['pedido_data'] ?? null,
            'pedido_total_geral' => $dados['pedido_total_geral'] ?? null,
            'pedido_status' => $dados['pedido_status'] ?? null,
            'funcionario_id' => $dados['funcionario_id'] ?? null,
            'pedido_ativo' => $dados['pedido_ativo'] ?? null,
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
        $response = $this->cadastrar_novo_pedido([
            'pedido_nome_cliente' => 'Geraldo',
            'pedido_data' => '01/01/2023',
            'pedido_total_geral' => '10,00',
            'pedido_status' => 1,
            'funcionario_id' => 1,
            'pedido_ativo' => 1,
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
            'pedido_ativo' => 1,
        ]);
        $responsePedido->assertStatus(201);

        $responseDelete = $this->deletar_pedido($responsePedido['dados']['id']);
        $responseDelete->assertStatus(200);
    }

}
