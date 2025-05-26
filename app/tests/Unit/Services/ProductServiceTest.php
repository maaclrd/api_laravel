<?php

namespace Tests\Unit\Services;

use App\Exceptions\ProductException;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected ProductService $service;
    protected ProductRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->repository);
    }

    public function test_should_find_product_by_id(): void
    {
        $product = new Product();
        $product->id = 1;

        $this->repository
            ->shouldReceive('findOne')
            ->once()
            ->with(1)
            ->andReturn($product);

        $result = $this->service->findById(1);

        $this->assertEquals($product, $result);
    }

    public function test_should_throw_exception_when_product_not_found(): void
    {
        $this->repository
            ->shouldReceive('findOne')
            ->once()
            ->with(1)
            ->andThrow(ProductException::notFound(1));

        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Produto #1 não encontrado');
        $this->expectExceptionCode(404);

        $this->service->findById(1);
    }

    public function test_should_create_product(): void
    {
        $data = [
            'name' => 'Produto Teste',
            'description' => 'Desc',
            'price' => 10.00,
            'stock' => 100
        ];

        $product = new Product();
        $product->fill($data);

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($product);

        $result = $this->service->create($data);

        $this->assertEquals($product, $result);
    }

    public function test_should_update_product(): void
    {
        $product = new Product();
        $product->id = 1;

        $data = ['name' => 'Atualizado'];

        $this->repository
            ->shouldReceive('findOne')
            ->twice()
            ->with(1)
            ->andReturn($product);

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn(true);

        $result = $this->service->update(1, $data);

        $this->assertInstanceOf(Product::class, $result);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}