<?php

namespace Tests\Unit\Repositories;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Classe CategoriaRepositoryTest
 *
 * Esta classe contém testes unitários para o CategoriaRepository.
 * Ela usa o trait RefreshDatabase para garantir um estado limpo para cada teste.
 */
class CategoriaRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CategoriasRepositoryInterface
     */
    protected CategoriasRepositoryInterface $repository;

    /**
     * Configura o ambiente de teste.
     *
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(CategoriasRepositoryInterface::class);
    }

    /**
     * Testa a criação de uma Categoria.
     *
     * @dataProvider categoriaProvider
     * @param string $nome O nome da categoria a ser criada.
     * @return void
     * @throws CategoriaNotCreatedException
     */
    #[DataProvider('categoriaProvider')]
    public function test_it_can_create_a_categoria(string $nome): void
    {
        $categoria = $this->repository->create(['nome' => $nome]);
        $this->assertDatabaseHas('categorias', ['nome' => $nome]);
        $this->assertEquals($nome, $categoria->nome);
    }

    /**
     * Testa a atualização de uma Categoria.
     *
     * @dataProvider categoriaProvider
     * @param string $nome O nome da categoria a ser atualizada.
     * @return void
     * @throws CategoriaNotFoundException
     * @throws CategoriaNotCreatedException
     * @throws CategoriaNotUpdatedException
     */
    #[DataProvider('categoriaProvider')]
    public function test_it_can_update_a_categoria(string $nome): void
    {
        $categoria = $this->repository->create(['nome' => $nome[0]]);
        $this->repository->updateById(['nome' => $nome[1]], $categoria->id);
        $this->assertDatabaseHas('categorias', ['nome' => $nome[1]]);
    }

    /**
     * Provedor de dados para test_it_can_create_a_categoria.
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
     * Testa a obtenção de uma Categoria por um ID inválido.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId O ID inválido a ser testado.
     * @return void
     * @throws CategoriaNotFoundException
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_getting_categoria_by_invalid_id(int $invalidId): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->repository->getById($invalidId);
    }

    /**
     * Testa a atualização de uma Categoria por um ID inválido.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId O ID inválido a ser testado.
     * @return void
     * @throws CategoriaNotUpdatedException
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_updating_categoria_by_invalid_id(int $invalidId): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->repository->updateById(['nome' => 'Categoria Teste Atualizada'], $invalidId);
    }

    /**
     * Testa a exclusão de uma Categoria por um ID inválido.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId O ID inválido a ser testado.
     * @return void
     * @throws CategoriaNotFoundException
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_deleting_categoria_by_invalid_id(int $invalidId): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->repository->deleteById($invalidId);
    }

    /**
     * Provedor de dados para testes de ID inválido.
     *
     * @return array
     */
    public static function invalidIdProvider(): array
    {
        return [
            [246246727237],
            [123456789012],
            [987654321098],
        ];
    }
}
