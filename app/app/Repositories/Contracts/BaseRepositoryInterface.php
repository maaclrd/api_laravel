<?php

namespace App\Repositories\Contracts;

use App\Classes\QueryBuilder\Sort;
use App\Classes\QueryBuilder\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function findAll(Filter $filter, Sort $sort, int $perPage = 10, bool $withTrashed = false): object;
    public function setFindAllFilters(Filter $filter, Model $model);
    public function findList(Filter $filter, Sort $sort, bool $withTrashed = false): object;
    public function create(array $attributes): object;
    public function findOne($value, string $field = 'id', array $with = []): object;
    public function update(int $id, array $attributes): mixed;
    public function delete(int $id): bool;
    public function getInactive(int $id): object;
    public function reactivate(int $id): bool;
    public function setModelOrderBy(Builder $model, Sort|array $sort): Builder;
    public function checkIfExists($value, string $field = 'id', ?int $whereNotId = null): bool;
} 