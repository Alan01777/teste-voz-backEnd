<?php

namespace Tests\Feature\Http\Controllers;

use App\Contracts\Services\ProdutosServiceInterface;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotDeletedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use App\Models\Categorias;
use App\Models\Produtos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ProdutosControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private ProdutosServiceInterface $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockService = Mockery::mock(ProdutosServiceInterface::class);
        $this->app->instance(ProdutosServiceInterface::class, $this->mockService);
    }

    /**
     * Test the listing of all products.
     */
    public function test_it_can_list_all_products(): void
    {
        $produtos = Produtos::factory()->count(3)->make();
        $this->mockService->shouldReceive('getAll')->once()->andReturn($produtos);

        $response = $this->getJson(route('produtos.index'));

        $response->assertStatus(200)
                 ->assertJson($produtos->toArray());
    }

    /**
     * Test the display of a single product.
     */
    public function test_it_can_show_a_product(): void
    {
        $produto = Produtos::factory()->make();
        $this->mockService->shouldReceive('getById')->with(1)->once()->andReturn($produto);

        $response = $this->getJson(route('produtos.show', 1));

        $response->assertStatus(200)
                 ->assertJson($produto->toArray());
    }

    /**
     * Test the display of a non-existent product.
     */
    public function test_it_returns_404_if_product_not_found(): void
    {
        $this->mockService->shouldReceive('getById')->with(1)->once()->andThrow(new ProdutoNotFoundException());

        $response = $this->getJson(route('produtos.show', 1));

        $response->assertStatus(404);
    }

    /**
     * Test the creation of a new product.
     */
    public function test_it_can_create_a_product(): void
    {
        $categoria = Categorias::factory()->create(['nome' => 'Categoria Teste']);
        $data = ['nome' => 'Produto Teste 1', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00, 'categoria_id' => $categoria->id];
        $produto = Produtos::factory()->make($data);
        $this->mockService->shouldReceive('create')->with($data)->once()->andReturn($produto);

        $response = $this->postJson(route('produtos.store'), $data);

        $response->assertStatus(201)
                 ->assertJson($produto->toArray());
    }

    /**
     * Test the creation of a new product with invalid data.
     */
    public function test_it_returns_422_if_product_creation_fails(): void
    {
        $data = ['nome' => '', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00];
        $this->mockService->shouldReceive('create')->with($data)->never();

        $response = $this->postJson(route('produtos.store'), $data);

        $response->assertStatus(422);
    }

    /**
     * Test the update of an existing product.
     */
    public function test_it_can_update_a_product(): void
    {
        $categoria = Categorias::factory()->create(['nome' => 'Categoria Teste']);
        $data = ['nome' => 'Produto Teste 1', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00, 'categoria_id' => $categoria->id];
        $produto = Produtos::factory()->make($data);
        $this->mockService->shouldReceive('updateById')->with($data, 1)->once()->andReturn($produto);

        $response = $this->putJson(route('produtos.update', 1), $data);

        $response->assertStatus(200)
                 ->assertJson($produto->toArray());
    }

    /**
     * Test the update of a product with invalid data.
     */
    public function test_it_returns_422_if_product_update_fails(): void
    {
        $data = ['nome' => '', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00];
        $this->mockService->shouldReceive('updateById')->with($data, 1)->never();

        $response = $this->putJson(route('produtos.update', 1), $data);

        $response->assertStatus(422);
    }

    /**
     * Test the deletion of a product.
     */
    public function test_it_can_delete_a_product(): void
    {
        $this->mockService->shouldReceive('deleteById')->with(1)->once()->andReturn(true);

        $response = $this->deleteJson(route('produtos.destroy', 1));

        $response->assertStatus(204);
    }

    /**
     * Test the deletion of a non-existent product.
     */
    public function test_it_returns_404_if_product_deletion_fails(): void
    {
        $this->mockService->shouldReceive('deleteById')->with(1)->once()->andThrow(new ProdutoNotFoundException());

        $response = $this->deleteJson(route('produtos.destroy', 1));

        $response->assertStatus(404);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
