<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\ProdutosServiceInterface;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotDeletedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\ProdutosRequest as Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Classe ProdutosController
 *
 * Controlador para lidar com requisições de API relacionadas a produtos.
 */
class ProdutosController extends Controller
{
    /**
     * @var ProdutosServiceInterface
     */
    protected ProdutosServiceInterface $service;

    /**
     * Construtor do ProdutosController.
     *
     * @param ProdutosServiceInterface $service
     */
    public function __construct(ProdutosServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Exibe uma lista de produtos.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    /**
     * Exibe um produto específico.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try{
            $produto = $this->service->getById($id);
            return response()->json($produto);
        } catch (ProdutoNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Armazena um novo produto.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try{
            $data = $request->validated();
            $produto = $this->service->create($data);
            return response()->json($produto, ResponseAlias::HTTP_CREATED);
        } catch (ProdutoNotCreatedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Atualiza um produto específico.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try{
            $data = $request->validated();
            $produto = $this->service->updateById($data, $id);
            return response()->json($produto);
        } catch (ProdutoNotCreatedException|ProdutoNotUpdatedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove um produto específico.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $this->service->deleteById($id);
            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (ProdutoNotFoundException|ProdutoNotDeletedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
