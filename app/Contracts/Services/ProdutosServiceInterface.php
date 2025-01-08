<?php

namespace App\Contracts\Services;

use App\Models\Produtos;
use Illuminate\Database\Eloquent\Collection;

interface ProdutosServiceInterface
{
    /**
     * Recupera todos os produtos.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Recupera um produto pelo seu ID.
     *
     * @param int $id
     * @return Produtos|null
     */
    public function getById(int $id): ?Produtos;

    /**
     * Cria um novo produto.
     *
     * @param array $data
     * @return Produtos
     */
    public function create(array $data): Produtos;

    /**
     * Atualiza um produto pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Produtos|null
     */
    public function updateById(array $data, int $id): ?Produtos;

    /**
     * Deleta um produto pelo seu ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
