<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProdutosRepositoryInterface;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotDeletedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use App\Models\Produtos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutosRepository implements ProdutosRepositoryInterface
{

    protected Produtos $model;

    public function __construct(Produtos $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->model->with('categoria')->get();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Produtos
    {
        $categoria =  $this->model->with('categoria')->find($id);
        if(!$categoria){
            throw new ProdutoNotFoundException();
        }
        return $categoria;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Produtos
    {
        $produto = new Produtos($data);
        if(!$produto->save()){
            throw new ProdutoNotCreatedException();
        }
        return $produto;
    }

    /**
     * @inheritDoc
     */
    public function updateById(array $data, int $id): ?Produtos
    {
        $produto = $this->getById($id);
        if(!$produto->update($data)){
            throw new ProdutoNotUpdatedException();
        }
        return $produto;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        $produto = $this->getById($id);
        if (!$produto->delete()) {
            throw new ProdutoNotFoundException();
        }
        return true;
    }
}
