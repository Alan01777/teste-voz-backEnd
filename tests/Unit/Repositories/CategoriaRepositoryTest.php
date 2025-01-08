<?php

namespace Tests\Unit\Repositories;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Classe CategoriaRepositoryTest
 *
 * Esta classe contém testes unitários para o CategoriaRepository.
 * Utiliza o trait RefreshDatabase para garantir um estado limpo para cada teste.
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
     */
    #[DataProvider('categoriaProvider')]
    public function testCreateCategoria(string $nome): void
    {
        $categoria = $this->repository->create(['nome' => $nome]);
        $this->assertDatabaseHas('categorias', ['nome' => $nome]);
        $this->assertEquals($nome, $categoria->nome);
    }

    /**
     * Provedor de dados para testCreateCategoria.
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
     */
    #[DataProvider('invalidIdProvider')]
    public function testGetCategoriaByIdWithInvalidId(int $invalidId): void
    {
        $categoria = $this->repository->getById($invalidId);
        $this->assertNull($categoria);
    }

    /**
     * Testa a atualização de uma Categoria por um ID inválido.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId O ID inválido a ser testado.
     * @return void
     */
    #[DataProvider('invalidIdProvider')]
    public function testUpdateCategoriaByIdWithInvalidId(int $invalidId): void
    {
        $updated = $this->repository->updateById(['nome' => 'Categoria Teste Atualizada'], $invalidId);
        $this->assertNull($updated);
    }

    /**
     * Testa a exclusão de uma Categoria por um ID inválido.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId O ID inválido a ser testado.
     * @return void
     */
    #[DataProvider('invalidIdProvider')]
    public function testDeleteCategoriaByIdWithInvalidId(int $invalidId): void
    {
        $deleted = $this->repository->deleteById($invalidId);
        $this->assertFalse($deleted);
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
