<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Classes\QueryBuilder\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function createQueryBuilder(): Builder
    {
        return $this->model->newQuery();
    }

    public function setFindAllFilters(Filter $filter, Model $model): Builder
    {
        $operator = \DB::getDriverName() === 'pgsql' ? 'ilike' : 'like';
        
        return $model
            ->withTrashed()
            ->when(!empty($filter->get('name')), function ($q) use ($filter) {
                $name = is_string($filter->get('name')) ? $filter->get('name') : '';
                return $q->where('name', 'like', '%' . $name . '%');
            })
            ->when(!empty($filter->get('price_min')), function ($q) use ($filter) {
                return $q->where('price', '>=', $filter->get('price_min'));
            })
            ->when(!empty($filter->get('price_max')), function ($q) use ($filter) {
                return $q->where('price', '<=', $filter->get('price_max'));
            })
            ->when(!empty($filter->get('stock_min')), function ($q) use ($filter) {
                return $q->where('stock', '>=', $filter->get('stock_min'));
            });
    }

    public function setModelOrderBy(Builder $model, \App\Classes\QueryBuilder\Sort|array $sort): Builder
    {
        $sortableFields = ['id', 'name', 'price', 'stock', 'created_at'];

        if (!is_array($sort)) {
            if (in_array($sort->getByField(), $sortableFields)) {
                return $model->orderBy($sort->getByField(), $sort->getType());
            }
            return $model;
        }

        foreach ($sort as $sortObject) {
            if (in_array($sortObject->getByField(), $sortableFields)) {
                $model = $model->orderBy($sortObject->getByField(), $sortObject->getType());
            }
        }

        return $model;
    }
} 