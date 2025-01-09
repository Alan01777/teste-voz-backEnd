<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Models\Categorias;
use Illuminate\Database\Eloquent\Collection;

class CategoriasRepository implements CategoriasRepositoryInterface
{
    protected Categorias $model;

    public function __construct(Categorias $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->model->with('produtos')->get();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Categorias
    {
        $categoria = $this->model->with('produtos')->find($id);
        if (!$categoria) {
            throw new CategoriaNotFoundException();
        }
        return $categoria;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Categorias
    {
        $categoria = new Categorias($data);
        if (!$categoria->save()) {
            throw new CategoriaNotCreatedException();
        }
        return $categoria;
    }

    /**
     * @inheritDoc
     */
    public function updateById(array $data, int $id): ?Categorias
    {
        $categoria = $this->getById($id);
        if (!$categoria->update($data)) {
            throw new CategoriaNotUpdatedException();
        }
        return $categoria;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        $categoria = $this->getById($id);
        if (!$categoria->delete()) {
            throw new CategoriaNotFoundException();
        }
        return true;
    }
}
