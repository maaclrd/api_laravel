<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function createQueryBuilder(): Builder;
} 