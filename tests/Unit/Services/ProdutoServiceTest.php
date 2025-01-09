<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\ProdutosRepositoryInterface;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotDeletedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use App\Models\Produtos;
use App\Services\ProdutosService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Mockery;

class ProdutoServiceTest extends TestCase
{
    private ProdutosRepositoryInterface $mockRepository;
    private ProdutosService $service;

    /**
     * Configura o ambiente de teste.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepository = Mockery::mock(ProdutosRepositoryInterface::class);
        $this->service = new ProdutosService($this->mockRepository);
    }

    /**
     * Testa a criação de um produto.
     *
     * @param string $nome Nome do produto.
     * @throws ProdutoNotCreatedException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_create_a_produto(string $nome): void
    {
        $mockProduto = new Produtos(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('create')->once()->andReturn($mockProduto);

        $result = $this->service->create(['nome' => $nome]);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a atualização de um produto.
     *
     * @param string $nome Nome do produto.
     * @throws ProdutoNotFoundException
     * @throws ProdutoNotUpdatedException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_update_a_produto(string $nome): void
    {
        $mockProduto = new Produtos(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('updateById')->once()->andReturn($mockProduto);

        $result = $this->service->updateById(['nome' => $nome], 1);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a obtenção de um produto.
     *
     * @param string $nome Nome do produto.
     * @throws ProdutoNotFoundException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_get_a_produto(string $nome): void
    {
        $mockProduto = new Produtos(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('getById')->once()->andReturn($mockProduto);

        $result = $this->service->getById(1);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a exclusão de um produto.
     *
     * @throws ProdutoNotFoundException
     */
    public function test_it_can_delete_a_produto(): void
    {
        $this->mockRepository->shouldReceive('deleteById')->once()->andReturn(true);

        $result = $this->service->deleteById(1);

        $this->assertTrue($result);
    }

    /**
     * Testa a exclusão de um produto com ID inválido.
     *
     * @throws ProdutoNotFoundException
     */
    public function test_it_throws_exception_when_deleting_produto_with_invalid_id(): void
    {
        $this->expectException(ProdutoNotFoundException::class);
        $this->mockRepository->shouldReceive('deleteById')->once()->andThrow(new ProdutoNotFoundException());

        $this->service->deleteById(1);
    }

    /**
     * Testa a obtenção de um produto com ID inválido.
     *
     * @throws ProdutoNotFoundException
     */
    public function test_it_throws_exception_when_getting_produto_with_invalid_id(): void
    {
        $this->expectException(ProdutoNotFoundException::class);
        $this->mockRepository->shouldReceive('getById')->once()->andThrow(new ProdutoNotFoundException());

        $this->service->getById(1);
    }

    /**
     * Testa a criação de um produto com dados inválidos.
     *
     * @param array $data Dados do produto.
     * @throws ProdutoNotCreatedException
     */
    #[DataProvider('invalidProdutoProvider')]
    public function test_it_throws_exception_when_creating_produto_with_invalid_data(array $data): void
    {
        $this->expectException(ProdutoNotCreatedException::class);
        $this->mockRepository->shouldReceive('create')->once()->andThrow(new ProdutoNotCreatedException());

        $this->service->create($data);
    }

    /**
     * Testa a atualização de um produto com dados inválidos.
     *
     * @param array $data Dados do produto.
     * @throws ProdutoNotFoundException
     */
    #[DataProvider('invalidProdutoProvider')]
    public function test_it_throws_exception_when_updating_produto_with_invalid_data(array $data): void
    {
        $this->expectException(ProdutoNotUpdatedException::class);
        $this->mockRepository->shouldReceive('updateById')->once()->andThrow(new ProdutoNotUpdatedException());

        $this->service->updateById($data, 1);
    }

    /**
     * Provedor de dados para testes de produtos válidos.
     *
     * @return array
     */
    public static function produtoProvider(): array
    {
        return [
            ['Produto Teste 1'],
            ['Produto Teste 2'],
            ['Produto Teste 3'],
        ];
    }

    /**
     * Provedor de dados para testes de produtos inválidos.
     *
     * @return array
     */
    public static function invalidProdutoProvider(): array
    {
        return [
            [['nome' => '']], // Nome vazio
            [['nome' => null]], // Nome nulo
            [[]], // Nome ausente
        ];
    }

    /**
     * Limpa o ambiente de teste.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
