<?php

namespace App\Services;

use App\Contracts\Repositories\ProdutosRepositoryInterface;
use App\Contracts\Services\ProdutosServiceInterface;
use App\Models\Produtos;
use Illuminate\Database\Eloquent\Collection;

class ProdutosService implements ProdutosServiceInterface
{

    protected ProdutosRepositoryInterface $repository;

    public function __construct(ProdutosRepositoryInterface $repository)
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
    public function getById(int $id): ?Produtos
    {
        return $this->repository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Produtos
    {
        return $this->repository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(array $data, int $id): ?Produtos
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
