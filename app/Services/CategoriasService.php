<?php

namespace App\Services;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Contracts\Services\CategoriasServiceInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Models\Categorias;
use Illuminate\Database\Eloquent\Collection;

class CategoriasService implements CategoriasServiceInterface
{
    protected CategoriasRepositoryInterface $repository;

    public function __construct(CategoriasRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Categorias
    {
        return $this->repository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Categorias
    {
        return $this->repository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(array $data, int $id): ?Categorias
    {
        return $this->repository->updateById($data, $id);
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        return $this->repository->deleteById($id);
    }
}
