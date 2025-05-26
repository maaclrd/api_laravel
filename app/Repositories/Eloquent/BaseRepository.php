<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Classes\QueryBuilder\Sort;
use App\Classes\QueryBuilder\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    protected array $fieldsToShow = ['*'];
    protected array $listFields = ['id', 'name'];
    protected array $with = [];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function findAll(Filter $filter, Sort|array $sort, int $perPage = 10, bool $withTrashed = false, array $with = []): object
    {
        $model = $this->setFindAllFilters($filter, $this->model);

        if ($withTrashed) {
            $model = $model->withTrashed();
        }

        $model = $model->with(!empty($with) ? $with : $this->with);
        $model = $this->setModelOrderBy($model, $sort);

        return $model->paginate($perPage, $this->fieldsToShow);
    }

    public function setModelOrderBy(Builder $model, Sort|array $sort): Builder
    {
        if (!is_array($sort)) {
            return $model->orderBy($sort->getByField(), $sort->getType());
        }

        foreach ($sort as $sortObject) {
            $model = $model->orderBy($sortObject->getByField(), $sortObject->getType());
        }

        return $model;
    }

    public function setFindAllFilters(Filter $filter, Model $model)
    {
        return $model->when(!empty($filter->id), function ($query) use ($filter) {
            return $query->where('id', $filter->id);
        });
    }

    public function findList(Filter $filter, Sort $sort, bool $withTrashed = false, array $with = []): object
    {
        $model = $this->setFindAllFilters($filter, $this->model);

        if ($withTrashed) {
            $model = $model->withTrashed();
        }

        return $model
            ->select($this->listFields)
            ->with(!empty($with) ? $with : $this->with)
            ->orderBy($sort->getByField(), $sort->getType())
            ->limit(100)
            ->get();
    }

    public function create(array $attributes): object
    {
        return $this->model->create($attributes);
    }

    public function findOne($value, string $field = 'id', array $with = []): object
    {
        $model = $this->model
            ->with(!empty($with) ? $with : $this->with)
            ->where($field, $value)
            ->first();

        if (empty($model)) {
            throw new ModelNotFoundException('Não foi possível encontrar o registro', 404);
        }

        return $model;
    }

    public function checkIfExists($value, string $field = 'id', ?int $whereNotId = null): bool
    {
        $model = $this->model->where($field, $value);

        if ($whereNotId) {
            $model = $model->whereNot('id', $whereNotId);
        }

        return $model->exists();
    }

    public function update(int $id, array $attributes, ?Model $model = null): mixed
    {
        if (!$model) {
            $model = $this->findOne($id);
        }

        if (empty($model)) {
            throw new ModelNotFoundException('Não foi possível encontrar o registro', 404);
        }

        return $model->update($attributes);
    }

    public function massUpdate(array $data, array $conditions): bool
    {
        $model = $this->model;

        foreach ($conditions as $field => $value) {
            $model = $model->where($field, $value);
        }

        return (bool) $model->update($data);
    }

    public function delete(int $id): bool
    {
        $model = $this->findOne($id);

        return $model->delete();
    }

    public function getInactive(int $id): object
    {
        return $this->model->withTrashed()->whereId($id)->firstOrFail();
    }

    public function reactivate(int $id): bool
    {
        $model = $this->getInactive($id);

        return $model->restore();
    }
} 