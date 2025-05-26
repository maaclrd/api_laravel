<?php

declare(strict_types=1);

namespace App\Services;

use App\Classes\QueryBuilder\Filter;
use App\Classes\QueryBuilder\Sort;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Services\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseService implements BaseServiceInterface
{
    protected BaseRepositoryInterface $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function findAll($data): object
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array');
        }
        $filter = Filter::formatFilters($data);
        $sort = $this->formatSort($data);
        $perPage = !empty($data['perPage']) ? (int)$data['perPage'] : 10;
        $withTrashed = !empty($data['withTrashed']) ? filter_var($data['withTrashed'], FILTER_VALIDATE_BOOLEAN) : false;

        return $this->repository->findAll($filter, $sort, $perPage, $withTrashed);
    }

    public function formatSort(array $data): Sort
    {
        return Sort::formatSort($data);
    }

    public function findList(array $data, $sortBy = 'name'): object
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array');
        }

        $filter = Filter::formatFilters($data);
        $sort = Sort::formatSort($data, $sortBy);
        $withTrashed = !empty($data['withTrashed']) ? (bool)$data['withTrashed'] : false;

        return $this->repository->findList($filter, $sort, $withTrashed);
    }

    public function create(array $attributes): object
    {
        if (empty($attributes)) {
            throw new \InvalidArgumentException('Attributes cannot be empty');
        }

        if (!empty($attributes['created_by'])) {
            $attributes['updated_by'] = $attributes['created_by'];
        }

        return $this->repository->create($attributes);
    }

    public function findOne(int $id): object
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        return $this->repository->findOne($id);
    }

    public function update(int $id, array $attributes): mixed
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        if (empty($attributes)) {
            throw new \InvalidArgumentException('Attributes cannot be empty');
        }

        return $this->repository->update($id, $attributes);
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        return $this->repository->delete($id);
    }

    public function getInactive(int $id): object
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        return $this->repository->getInactive($id);
    }

    public function reactivate(int $id): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        return $this->repository->reactivate($id);
    }

    public function checkIfExists(int|string $value, string $field = 'id', ?int $whereNotId = null): bool
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Value cannot be empty');
        }

        if (empty($field)) {
            throw new \InvalidArgumentException('Field cannot be empty');
        }

        if ($whereNotId !== null && $whereNotId <= 0) {
            throw new \InvalidArgumentException('Invalid whereNotId provided');
        }

        return $this->repository->checkIfExists($value, $field, $whereNotId);
    }

    public function restore(int $id): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid ID provided');
        }

        return $this->repository->reactivate($id);
    }
} 