<?php

namespace Tests\Feature\Http\Controllers;

use App\Contracts\Services\CategoriasServiceInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Models\Categorias;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CategoriasControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private CategoriasServiceInterface $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockService = Mockery::mock(CategoriasServiceInterface::class);
        $this->app->instance(CategoriasServiceInterface::class, $this->mockService);
    }

    /**
     * Testa a listagem de todas as categorias.
     */
    public function test_it_can_list_all_categories(): void
    {
        $categorias = Categorias::factory()->count(3)->make();
        $paginator = new LengthAwarePaginator($categorias, 3, 10, 1, [
            'path' => Paginator::resolveCurrentPath(),
        ]);

        $this->mockService->shouldReceive('getAll')->once()->andReturn($paginator);

        $response = $this->getJson(route('categorias.index'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => $categorias->toArray(),
                'pagination' => [
                    'total' => 3,
                    'count' => 3,
                    'per_page' => 10,
                    'current_page' => 1,
                    'total_pages' => 1,
                ],
            ]);
    }

    /**
     * Testa a exibição de uma única categoria.
     */
    public function test_it_can_show_a_category(): void
    {
        $categoria = Categorias::factory()->make();
        $this->mockService->shouldReceive('getById')->with(1)->once()->andReturn($categoria);

        $response = $this->getJson(route('categorias.show', 1));

        $response->assertStatus(200)
                 ->assertJson($categoria->toArray());
    }

    /**
     * Testa a exibição de uma categoria inexistente.
     */
    public function test_it_returns_404_if_category_not_found(): void
    {
        $this->mockService->shouldReceive('getById')->with(1)->once()->andThrow(new CategoriaNotFoundException());

        $response = $this->getJson(route('categorias.show', 1));

        $response->assertStatus(404);
    }

    /**
     * Testa a criação de uma nova categoria.
     */
    #[DataProvider('validCategoriaProvider')]
    public function test_it_can_create_a_category(array $data): void
    {
        $categoria = Categorias::factory()->make($data);
        $this->mockService->shouldReceive('create')->with($data)->once()->andReturn($categoria);

        $response = $this->postJson(route('categorias.store'), $data);

        $response->assertStatus(201)
                 ->assertJson($categoria->toArray());
    }

    /**
     * Testa a criação de uma nova categoria com dados inválidos.
     */
    #[DataProvider('invalidCategoriaProvider')]
    public function test_it_returns_422_if_category_creation_fails(array $data): void
    {
        $this->mockService->shouldReceive('create')->with($data)->never();

        $response = $this->postJson(route('categorias.store'), $data);

        $response->assertStatus(422);
    }

    /**
     * Testa a atualização de uma categoria existente.
     */
    #[DataProvider('validCategoriaProvider')]
    public function test_it_can_update_a_category(array $data): void
    {
        $categoria = Categorias::factory()->make($data);
        $this->mockService->shouldReceive('updateById')->with($data, 1)->once()->andReturn($categoria);

        $response = $this->putJson(route('categorias.update', 1), $data);

        $response->assertStatus(200)
                 ->assertJson($categoria->toArray());
    }

    /**
     * Testa a atualização de uma categoria com dados inválidos.
     */
    #[DataProvider('invalidCategoriaProvider')]
    public function test_it_returns_422_if_category_update_fails(array $data): void
    {
        $this->mockService->shouldReceive('updateById')->with($data, 1)->never();

        $response = $this->putJson(route('categorias.update', 1), $data);

        $response->assertStatus(422);
    }

    /**
     * Testa a atualização de uma categoria que não existe.
     */
    #[DataProvider('validCategoriaProvider')]
    public function test_it_returns_404_if_category_update_fails(array $data): void
    {
        $this->mockService->shouldReceive('updateById')->with($data, 1)->once()->andThrow(new CategoriaNotFoundException());

        $response = $this->putJson(route('categorias.update', 1), $data);

        $response->assertStatus(404);
    }

    /**
     * Testa a exclusão de uma categoria.
     */
    public function test_it_can_delete_a_category(): void
    {
        $this->mockService->shouldReceive('deleteById')->with(1)->once()->andReturn(true);

        $response = $this->deleteJson(route('categorias.destroy', 1));

        $response->assertStatus(204);
    }

    /**
     * Testa a exclusão de uma categoria inexistente.
     */
    public function test_it_returns_404_if_category_deletion_fails(): void
    {
        $this->mockService->shouldReceive('deleteById')->with(1)->once()->andThrow(new CategoriaNotFoundException());

        $response = $this->deleteJson(route('categorias.destroy', 1));

        $response->assertStatus(404);
    }

    /**
     * Provedor de dados para categorias válidas.
     */
    public static function validCategoriaProvider(): array
    {
        return [
            [['nome' => 'Categoria Teste 1']],
            [['nome' => 'Categoria Teste 2']],
            [['nome' => 'Categoria Teste 3']],
        ];
    }

    /**
     * Provedor de dados para categorias inválidas.
     */
    public static function invalidCategoriaProvider(): array
    {
        return [
            [['nome' => '']],
            [['nome' => null]],
            [[]],
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
