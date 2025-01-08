<?php

namespace App\Contracts\Services;

use App\Models\Categorias;
use \Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Recupera uma categoria pelo seu ID.
     *
     * @param int $id
     * @return Categorias|null
     */
    public function getById(int $id): ?Categorias;

    /**
     * Cria uma nova categoria.
     *
     * @param array $data
     * @return Categorias
     */
    public function create(array $data): Categorias;

    /**
     * Atualiza uma categoria pelo seu ID.
     *
     * @param array $data
     * @param int $id
     * @return Categorias|null
     */
    public function updateById(array $data, int $id): ?Categorias;

    /**
     * Deleta uma categoria pelo seu ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
