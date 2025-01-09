<?php

namespace App\Contracts\Repositories;

use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotDeletedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Models\Categorias;
use \Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoriasRepositoryInterface
 *
 * Esta interface define os métodos que devem ser implementados por qualquer classe
 * que sirva como repositório para a model Categorias. Ela fornece um contrato
 * para operações básicas de CRUD.
 *
 * @package App\Contracts\Repositories
 */
interface CategoriasRepositoryInterface
{
    /**
     * Recupera todas as categorias.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Recupera uma categoria pelo seu ID.
     *
     * @param int $id
     * @return Categorias|null
     * @throws CategoriaNotFoundException
     */
    public function getById(int $id): ?Categorias;

    /**
     * Cria uma nova categoria.
     *
     * @param array $data
     * @return Categorias
     * @throws CategoriaNotCreatedException
     */
    public function create(array $data) : Categorias;

    /**
     * Atualiza uma categoria pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Categorias|null
     * @throws CategoriaNotUpdatedException|CategoriaNotFoundException
     */
    public function updateById(array $data, int $id) : ?Categorias;

    /**
     * Deleta uma categoria pelo seu ID.
     *
     * @param int $id
     * @return bool
     * @throws CategoriaNotFoundException
     */
    public function deleteById(int $id) : bool;
}
