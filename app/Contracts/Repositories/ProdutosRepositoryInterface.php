<?php

namespace App\Contracts\Repositories;
use App\Exceptions\Repositories\Produto\ProdutoNotCreatedException;
use App\Exceptions\Repositories\Produto\ProdutoNotDeletedException;
use App\Exceptions\Repositories\Produto\ProdutoNotFoundException;
use App\Exceptions\Repositories\Produto\ProdutoNotUpdatedException;
use \Illuminate\Database\Eloquent\Collection;
use \App\Models\Produtos;

/**
 * Interface ProdutosRepositoryInterface
 *
 * Esta interface define os métodos que devem ser implementados por qualquer classe
 * que sirva como repositório para a model Produtos. Ela fornece um contrato
 * para operações básicas de CRUD.
 *
 * @package App\Contracts\Repositories
 */
interface ProdutosRepositoryInterface
{
    /**
     * Recupera todos os produtos.
     *
     * @return Collection
     */
    public function getAll():  Collection;

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
     *
     * @param array $data
     * @return Produtos
     * @throws ProdutoNotCreatedException
     */
    public function create(array $data) : Produtos;

    /**
     * Atualiza um produto pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Produtos|null
     * @throws ProdutoNotUpdatedException|ProdutoNotFoundException
     */
    public function updateById(array $data, int $id) : ?Produtos;

    /**
     * Deleta um produto pelo seu ID.
     *
     * @param int $id
     * @return bool
     * @throws ProdutoNotFoundException|ProdutoNotDeletedException
     */
    public function deleteById(int $id) : bool;
}
