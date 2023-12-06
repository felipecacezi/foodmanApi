<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MesaTest extends TestCase
{
    use RefreshDatabase;
    const URL_BASE = '/api/mesa/';

    private function arrayCriacaoMesa(array $dados = []) :array
    {
        return [
            'mesa_identificacao' => $dados['mesa_identificacao'] ?? null,
            'mesa_ativo' => $dados['mesa_ativo'] ?? null,
        ];
    }

    private function arrayAlteracaoMesa(array $dados = []) :array
    {
        $dadosCriacao = $this->arrayCriacaoMesa($dados);
        $dadosCriacao['id'] = $dados['id'];
        return $dadosCriacao;
    }

    public function cadastrar_nova_mesa(array $dados = [])
    {
        return $this->post(
            self::URL_BASE,
            $this->arrayCriacaoMesa($dados),
        );
    }

    private function listar_mesas(string $queryString = '')
    {
        return $this->get(
            self::URL_BASE.$queryString,
        );
    }

    private function atualizar_mesa(array $dados = [])
    {
        return $this->put(
            self::URL_BASE,
            $this->arrayAlteracaoMesa($dados),
        );
    }

    private function deletar_mesa(int $idMesa = null)
    {
        return $this->delete(
            self::URL_BASE,
            [
                'id' => $idMesa
            ],
        );
    }

    public function test_cadastro_erro_campos_vazios()
    {
        $response = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => null,
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => null,
        ]);
        $response->assertStatus(422);
    }

    public function test_cadastro_sucesso()
    {
        $response = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(201);
    }

    public function test_listar_todos():void
    {
        $response = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(201);
        $mesas = $this->listar_mesas();
        $this->assertCount(1, $mesas['dados']);
    }

    public function test_listar_mesa_filtro():void
    {
        $responseMesa01 = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa01->assertStatus(201);

        $responseMesa02 = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 02',
            'mesa_ativo' => 1,
        ]);
        $responseMesa02->assertStatus(201);

        $mesas = $this->listar_mesas("?id={$responseMesa01['dados']['id']}");
        $this->assertCount(1, $mesas['dados']);

        $mesas = $this->listar_mesas("?mesa_identificacao={$responseMesa02['dados']['mesa_identificacao']}");
        $this->assertCount(1, $mesas['dados']);

        $mesas = $this->listar_mesas("?mesa_ativo=0");
        $this->assertCount(0, $mesas['dados']);
    }

    public function test_alteracao_erro_nome_vazio(): void
    {

        $responseMesa = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa->assertStatus(201);

        $response = $this->atualizar_mesa([
            'id' => null,
            'mesa_identificacao' => "Mesa 01",
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_mesa([
            'id' => $responseMesa['dados']['id'],
            'mesa_identificacao' => null ,
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->atualizar_mesa([
            'id' => $responseMesa['dados']['id'],
            'mesa_identificacao' => 'Mesa 01' ,
            'mesa_ativo' => null,
        ]);
        $response->assertStatus(422);

    }

    public function test_alteracao_sucesso(): void
    {

        $responseMesa = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa->assertStatus(201);

        $response = $this->atualizar_mesa([
            'id' => $responseMesa['dados']['id'],
            'mesa_identificacao' => "Mesa 01",
            'mesa_ativo' => 1,
        ]);
        $response->assertStatus(200);

    }

    public function test_delecao_erro_id_vazio(): void
    {
        $responseMesa = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa->assertStatus(201);
        $response = $this->deletar_mesa();
        $response->assertStatus(422);
    }

    public function test_delecao_sucesso(): void
    {
        $responseMesa = $this->cadastrar_nova_mesa([
            'mesa_identificacao' => 'Mesa 01',
            'mesa_ativo' => 1,
        ]);
        $responseMesa->assertStatus(201);
        $response = $this->deletar_mesa($responseMesa['dados']['id']);
        $response->assertStatus(200);
    }


}
