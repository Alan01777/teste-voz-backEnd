<?php

namespace App\Contracts\Services;

use App\Exceptions\Repositories\Categoria\CategoriaNotCreatedException;
use App\Exceptions\Repositories\Categoria\CategoriaNotFoundException;
use App\Exceptions\Repositories\Categoria\CategoriaNotUpdatedException;
use App\Models\Categorias;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface CategoriasServiceInterface
 *
 * Esta interface define os métodos que devem ser implementados por qualquer classe
 * que sirva como serviço para a model Categorias. Ela fornece um contrato
 * para operações básicas de CRUD.
 *
 * @package App\Contracts\Services
 */
interface CategoriasServiceInterface
{
    /**
     * Recupera todas as categorias.
     *
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator;

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
    public function create(array $data): Categorias;

    /**
     * Atualiza uma categoria pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Categorias|null
     * @throws CategoriaNotFoundException|CategoriaNotUpdatedException
     */
    public function updateById(array $data, int $id): ?Categorias;

    /**
     * Deleta uma categoria pelo seu ID.
     *
     * @param int $id
     * @return bool
     * @throws CategoriaNotFoundException
     */
    public function deleteById(int $id): bool;
}
