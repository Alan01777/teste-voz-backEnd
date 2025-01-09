<?php

namespace Repositories;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Contracts\Repositories\ProdutosRepositoryInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProdutoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProdutosRepositoryInterface $repository;
    protected CategoriasRepositoryInterface $categoriaRepository;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(ProdutosRepositoryInterface::class);
        $this->categoriaRepository = $this->app->make(CategoriasRepositoryInterface::class);
    }

    /**
     * Testa a criação de um produto.
     *
     * @throws ProdutoNotCreatedException
     * @throws CategoriaNotCreatedException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_create_a_product(array $produtoData): void
    {
        $categoria = $this->categoriaRepository->create(['nome' => 'Categoria Teste']);
        $produtoData['categoria_id'] = $categoria->id;

        $produto = $this->repository->create($produtoData);

        $this->assertDatabaseHas('produtos', ['nome' => $produtoData['nome']]);
        $this->assertEquals($produtoData['nome'], $produto->nome);
    }

    /**
     * Testa a atualização de um produto.
     * @throws CategoriaNotCreatedException
     * @throws ProdutoNotCreatedException
     * @throws ProdutoNotFoundException
     * @throws ProdutoNotUpdatedException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_update_a_product(array $produtoData): void
    {
        $categoria = $this->categoriaRepository->create(['nome' => 'Categoria Teste']);
        $produtoData['categoria_id'] = $categoria->id;

        $produto = $this->repository->create($produtoData);

        $produtoAtualizado = $this->repository->updateById(['nome' => 'Produto Atualizado'], $produto->id);

        $this->assertDatabaseHas('produtos', ['nome' => 'Produto Atualizado']);
        $this->assertEquals('Produto Atualizado', $produtoAtualizado->nome);
    }

    /**
     * Testa a obtenção de todos os produtos.
     * @throws CategoriaNotCreatedException
     * @throws ProdutoNotCreatedException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_get_all_products(array $produtoData): void
    {
        $categoria = $this->categoriaRepository->create(['nome' => 'Categoria Teste']);
        $produtoData['categoria_id'] = $categoria->id;

        $this->repository->create($produtoData);
        $this->repository->create($produtoData);
        $this->repository->create($produtoData);

        $produtos = $this->repository->getAll();

        $this->assertCount(3, $produtos);
    }

    /**
     * Testa a exclusão de um produto.
     * @throws CategoriaNotCreatedException
     * @throws ProdutoNotCreatedException
     * @throws ProdutoNotFoundException
     */
    #[DataProvider('produtoProvider')]
    public function test_it_can_delete_a_product(array $produtoProvider): void
    {
        $categoria = $this->categoriaRepository->create(['nome' => 'Categoria Teste']);
        $produtoProvider['categoria_id'] = $categoria->id;

        $produto = $this->repository->create($produtoProvider);

        $this->repository->deleteById($produto->id);

        $this->assertDatabaseMissing('produtos', ['nome' => $produtoProvider['nome']]);
    }

    // Testes para dados inválidos

    /**
     * Testa a criação de um produto com dados inválidos.
     * @dataProvider invalidProdutoProvider
     * @param array $produtoData
     * @throws ProdutoNotCreatedException
     */
    #[DataProvider('invalidProdutoProvider')]
    public function test_it_throws_exception_when_creating_product_with_invalid_data(array $produtoData): void
    {
        $this->expectException(QueryException::class);
        $this->repository->create($produtoData);
    }

    /**
     * Testa a atualização de um produto com dados inválidos.
     * @dataProvider invalidProdutoProvider
     * @param array $produtoData
     * @throws ProdutoNotCreatedException
     * @throws ProdutoNotFoundException
     * @throws ProdutoNotUpdatedException
     */
    #[DataProvider('invalidProdutoProvider')]
    public function test_it_throws_exception_when_updating_product_with_invalid_data(array $produtoData): void
    {
        $this->expectException(QueryException::class);
        $produto = $this->repository->create(['nome' => 'Produto Teste', 'descricao' => 'Descrição do Produto', 'preco' => 10.00]);
        $this->repository->updateById($produtoData, $produto->id);
    }

    /**
     * Testa a obtenção de um produto por um ID inválido.
     * @dataProvider invalidIdProvider
     * @param int $invalidId
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_getting_product_by_invalid_id(int $invalidId): void
    {
        $this->expectException(ProdutoNotFoundException::class);
        $this->repository->getById($invalidId);
    }

    /**
     * Testa a exclusão de um produto por um ID inválido.
     * @throws ProdutoNotFoundException
     */
    #[DataProvider('invalidIdProvider')]
    public function test_it_throws_exception_when_deleting_product_by_invalid_id(int $invalidId): void
    {
        $this->expectException(ProdutoNotFoundException::class);
        $this->repository->deleteById($invalidId);
    }

    public static function invalidIdProvider(): array
    {
        return [
            [0],
            [-1],
            [100],
        ];
    }

    public static function invalidProdutoProvider(): array
    {
        return [
            [['nome' => 'Produto 1', 'descricao' => 'Descrição do Produto 1']],
            [['nome' => 'Produto 2', 'preco' => 20.00]],
            [['descricao' => 'Descrição do Produto 3', 'preco' => 30.00]],
        ];
    }
    public static function produtoProvider(): array
    {
        return [
            [['nome' => 'Produto 1', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00]],
            [['nome' => 'Produto 2', 'descricao' => 'Descrição do Produto 2', 'preco' => 20.00]],
            [['nome' => 'Produto 3', 'descricao' => 'Descrição do Produto 3', 'preco' => 30.00]],
        ];
    }
}
