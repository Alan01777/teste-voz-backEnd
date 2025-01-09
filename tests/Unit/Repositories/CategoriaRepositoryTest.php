<?php

namespace Tests\Unit\Repositories;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class CategoriaRepositoryTest
 *
 * This class contains unit tests for the CategoriaRepository.
 * It uses the RefreshDatabase trait to ensure a clean state for each test.
 */
class CategoriaRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CategoriasRepositoryInterface
     */
    protected CategoriasRepositoryInterface $repository;

    /**
     * Sets up the test environment.
     *
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(CategoriasRepositoryInterface::class);
    }

    /**
     * Tests the creation of a Categoria.
     *
     * @dataProvider categoriaProvider
     * @param string $nome The name of the category to be created.
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
     * Tests the update of a Categoria.
     *
     * @dataProvider categoriaProvider
     * @param string $nome The name of the category to be updated.
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
     * Data provider for test_it_can_create_a_categoria.
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
     * Tests getting a Categoria by an invalid ID.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId The invalid ID to be tested.
     * @return void
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_getting_categoria_by_invalid_id(int $invalidId): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->repository->getById($invalidId);
    }

    /**
     * Tests updating a Categoria by an invalid ID.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId The invalid ID to be tested.
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
     * Tests deleting a Categoria by an invalid ID.
     *
     * @dataProvider invalidIdProvider
     * @param int $invalidId The invalid ID to be tested.
     * @return void
     * @throws CategoriaNotDeletedException
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_deleting_categoria_by_invalid_id(int $invalidId): void
    {
        $this->expectException(CategoriaNotFoundException::class);
        $this->repository->deleteById($invalidId);
    }

    /**
     * Data provider for invalid ID tests.
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
