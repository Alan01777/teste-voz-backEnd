<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoriasRequest as Request;
use App\Contracts\Services\CategoriasServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Classe CategoriasController
 *
 * Este controlador lida com as operações CRUD para o recurso Categorias.
 *
 * @package App\Http\Controllers\Api\V1
 */
class CategoriasController extends Controller
{
    /**
     * @var CategoriasServiceInterface
     */
    protected CategoriasServiceInterface $service;

    /**
     * Construtor do CategoriasController.
     *
     * @param CategoriasServiceInterface $service
     */
    public function __construct(CategoriasServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Exibe uma lista do recurso.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    /**
     * Exibe o recurso especificado.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $categoria = $this->service->getById($id);
            return response()->json($categoria);
        } catch (CategoriaNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Armazena um novo recurso no armazenamento.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $categoria = $this->service->create($data);
            return response()->json($categoria, ResponseAlias::HTTP_CREATED);
        } catch (CategoriaNotCreatedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Atualiza o recurso especificado no armazenamento.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updated = $this->service->updateById($data, $id);
            return response()->json($updated);
        } catch (CategoriaNotFoundException | CategoriaNotUpdatedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove o recurso especificado do armazenamento.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteById($id);
            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (CategoriaNotFoundException | CategoriaNotDeletedException $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
