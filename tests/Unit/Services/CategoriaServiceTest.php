<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Models\Categorias;
use App\Services\CategoriasService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Mockery;

class CategoriaServiceTest extends TestCase
{
    private CategoriasRepositoryInterface $mockRepository;
    private CategoriasService $service;

    /**
     * Configura o ambiente de teste.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepository = Mockery::mock(CategoriasRepositoryInterface::class);
        $this->service = new CategoriasService($this->mockRepository);
    }

    /**
     * Testa a criação de uma categoria.
     *
     * @param string $nome Nome da categoria.
     * @throws CategoriaNotCreatedException
     */
    #[DataProvider('categoriaProvider')]
    public function test_it_can_create_a_categoria(string $nome): void
    {
        $mockCategoria = new Categorias(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('create')->once()->andReturn($mockCategoria);

        $result = $this->service->create(['nome' => $nome]);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a atualização de uma categoria.
     *
     * @param string $nome Nome da categoria.
     * @throws CategoriaNotFoundException
     * @throws CategoriaNotUpdatedException
     */
    #[DataProvider('categoriaProvider')]
    public function test_it_can_update_a_categoria(string $nome): void
    {
        $mockCategoria = new Categorias(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('updateById')->once()->andReturn($mockCategoria);

        $result = $this->service->updateById(['nome' => $nome], 1);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a obtenção de uma categoria.
     *
     * @param string $nome Nome da categoria.
     * @throws CategoriaNotFoundException
     */
    #[DataProvider('categoriaProvider')]
    public function test_it_can_get_a_categoria(string $nome): void
    {
        $mockCategoria = new Categorias(['id' => 1, 'nome' => $nome]);
        $this->mockRepository->shouldReceive('getById')->once()->andReturn($mockCategoria);

        $result = $this->service->getById(1);

        $this->assertEquals($nome, $result->nome);
    }

    /**
     * Testa a exclusão de uma categoria.
     *
     * @throws CategoriaNotFoundException
     * @throws CategoriaNotFoundException
     */
    public function test_it_can_delete_a_categoria(): void
    {
        $this->mockRepository->shouldReceive('deleteById')->once()->andReturn(true);

        $result = $this->service->deleteById(1);

        $this->assertTrue($result);
    }

    /**
     * Testa a exclusão de uma categoria com ID inválido.
     *
     * @throws CategoriaNotFoundException
     */
    public function test_it_throws_exception_when_deleting_categoria_with_invalid_id(): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->mockRepository->shouldReceive('deleteById')->once()->andThrow(new CategoriaNotFoundException());

        $this->service->deleteById(1);
    }

    /**
     * Testa a obtenção de uma categoria com ID inválido.
     *
     * @throws CategoriaNotFoundException
     */
    public function test_it_throws_exception_when_getting_categoria_with_invalid_id(): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->mockRepository->shouldReceive('getById')->once()->andThrow(new CategoriaNotFoundException());

        $this->service->getById(1);
    }

    /**
     * Testa a criação de uma categoria com dados inválidos.
     *
     * @param array $data Dados da categoria.
     * @throws CategoriaNotCreatedException
     */
    #[DataProvider('invalidCategoriaProvider')]
    public function test_it_throws_exception_when_creating_categoria_with_invalid_data(array $data): void
    {
        $this->expectException(CategoriaNotCreatedException::class);
        $this->mockRepository->shouldReceive('create')->once()->andThrow(new CategoriaNotCreatedException());

        $this->service->create($data);
    }

    /**
     * Testa a atualização de uma categoria com dados inválidos.
     *
     * @param array $data Dados da categoria.
     * @throws CategoriaNotFoundException
     */
    #[DataProvider('invalidCategoriaProvider')]
    public function test_it_throws_exception_when_updating_categoria_with_invalid_data(array $data): void
    {
        $this->expectException(CategoriaNotUpdatedException::class);
        $this->mockRepository->shouldReceive('updateById')->once()->andThrow(new CategoriaNotUpdatedException());

        $this->service->updateById($data, 1);
    }

    /**
     * Provedor de dados para testes de categorias válidas.
     *
     * @return array
     */
    public static function categoriaProvider(): array
    {
        return [
            ['Categoria Teste 1'],
            ['Categoria Teste 2'],
            ['Categoria Teste 3'],
        ];
    }

    /**
     * Provedor de dados para testes de categorias inválidas.
     *
     * @return array
     */
    public static function invalidCategoriaProvider(): array
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
