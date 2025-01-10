<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\CategoriasServiceInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoriasRequest as Request;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoriasController extends Controller
{
    protected CategoriasServiceInterface $service;

    public function __construct(CategoriasServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json(new CategoriaCollection($this->service->getAll()));
    }

    public function show(int $id): JsonResponse
    {
        try {
            $categoria = $this->service->getById($id);
            return response()->json(new CategoriaResource($categoria));
        } catch (CategoriaNotFoundException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotFound', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $categoria = $this->service->create($data);
            return response()->json(new CategoriaResource($categoria), ResponseAlias::HTTP_CREATED);
        } catch (CategoriaNotCreatedException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotCreated', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updated = $this->service->updateById($data, $id);
            return response()->json(new CategoriaResource($updated), ResponseAlias::HTTP_OK);
        } catch (CategoriaNotFoundException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotFound', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_NOT_FOUND);
        } catch (CategoriaNotUpdatedException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotUpdated', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteById($id);
            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (CategoriaNotFoundException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotFoundException', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_NOT_FOUND);
        } catch (CategoriaNotDeletedException $e) {
            return response()->json(['error' => ['type' => 'CategoriaNotDeletedException', 'message' => $e->getMessage(), 'code' => $e->getCode()]], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
}
