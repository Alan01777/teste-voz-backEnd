<?php

namespace App\Contracts\Services;

use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use App\Models\Produtos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface ProdutosServiceInterface
{
    /**
     * Recupera todos os produtos.
     *
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator;

    /**
     * Recupera um produto pelo seu ID.
     *
     * @param int $id
     * @return Produtos|null
     * @throws ProdutoNotFoundException
     */
    public function getById(int $id): ?Produtos;

    /**
     * Cria um novo produto.
     *
     * @param array $data
     * @return Produtos
     * @throws ProdutoNotCreatedException
     */
    public function create(array $data): Produtos;

    /**
     * Atualiza um produto pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Produtos|null
     * @throws ProdutoNotFoundException|ProdutoNotUpdatedException
     */
    public function updateById(array $data, int $id): ?Produtos;

    /**
     * Deleta um produto pelo seu ID.
     *
     * @param int $id
     * @return bool
     * @throws ProdutoNotFoundException
     */
    public function deleteById(int $id): bool;
}
