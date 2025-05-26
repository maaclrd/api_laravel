<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Exceptions\ProductException;

class ProductService extends BaseService
{
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findById(int $id): object
    {
        $entity = $this->repository->findOne($id);

        if (!$entity) {
            throw ProductException::notFound($id);
        }

        return $entity;
    }

    public function create(array $attributes): object
    {
        return $this->repository->create($attributes);
    }

    public function update(int $id, array $data): object
    {
        $product = $this->findById($id);
        parent::update($id, $data);
        return $this->findById($id);
    }
} 