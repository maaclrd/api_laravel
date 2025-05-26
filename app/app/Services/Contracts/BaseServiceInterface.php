<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Classes\QueryBuilder\Sort;

/**
 * Interface para serviços base, com métodos obrigatórios para CRUD e operações comuns.
 */
interface BaseServiceInterface
{
    /**
     * Listagem de entidades utilizando filtros, paginação e ordenação.
     *
     * @param  array $data Informações de filtros, paginação e ordenação.
     * @return object
     */
    public function findAll(array $data): object;

    /**
     * Listagem em formato de lista (id, name).
     *
     * @param  array $data Informações de filtros, paginação e ordenação.
     * @param  string $sortBy Ordenação padrão.
     * @return object
     */
    public function findList(array $data, string $sortBy = 'name'): object;

    /**
     * Cadastro de nova entidade.
     *
     * @param  array $attributes Dados da entidade que será persistida no BD.
     * @return object
     */
    public function create(array $attributes): object;

    /**
     * Lista os dados de determinada entidade.
     *
     * @param  int $id Identificador único do que será buscado.
     * @return object
     */
    public function findOne(int $id): object;

    /**
     * Atualiza os dados da entidade.
     *
     * @param  int $id Identificador único do que será buscado.
     * @param  array $attributes Dados que serão atualizados.
     * @return mixed
     */
    public function update(int $id, array $attributes): mixed;

    /**
     * Exclusão da entidade (lógica ou não).
     *
     * @param  int $id Identificador único do que será buscado.
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Busca a entidade inativa pelo ID.
     *
     * @param  int $id Identificador único do que será buscado.
     * @return object
     */
    public function getInactive(int $id): object;

    /**
     * Reativa a entidade pelo ID.
     *
     * @param  int $id Identificador único do que será buscado.
     * @return bool
     */
    public function reactivate(int $id): bool;

    /**
     * Aplica uma paginação específica.
     *
     * @param  array $data Informações de filtros, paginação e ordenação.
     * @return Sort
     */
    public function formatSort(array $data): Sort;

    /**
     * Restaura uma entidade inativa pelo ID.
     *
     * @param  int $id Identificador único do que será buscado.
     * @return bool
     */
    public function restore(int $id): bool;
} 