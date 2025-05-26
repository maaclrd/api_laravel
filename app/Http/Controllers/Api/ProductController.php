<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\ProductException;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints para gerenciamento de produtos"
 * )
 */
class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Lista todos os produtos"
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $products = $this->service->findAll($request->all());
            return ProductResource::collection($products)
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::error('Erro ao listar produtos', ['exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Cria um novo produto"
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->service->create($request->validated());

            return response()->json([
                'data' => new ProductResource($product)
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            \Log::error('Erro ao criar produto', ['exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Retorna um produto específico"
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->service->findById($id);
            return response()->json([
                'data' => new ProductResource($product)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::error('Erro ao buscar produto', ['id' => $id, 'exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Atualiza um produto"
     * )
     */
    public function update(int $id, UpdateProductRequest $request): JsonResponse
    {
        try {
            $product = $this->service->update($id, $request->validated());
            return response()->json([
                'data' => new ProductResource($product)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::error('Erro ao atualizar produto', ['id' => $id, 'exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Remove um produto"
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            \Log::error('Erro ao remover produto', ['id' => $id, 'exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Patch(
     *     path="/products/{id}/restore",
     *     tags={"Products"},
     *     summary="Restaura um produto removido"
     * )
     */
    public function restore(int $id): JsonResponse
    {
        try {
            $this->service->restore($id);
            return response()->json(null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::error('Erro ao restaurar produto', ['id' => $id, 'exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * @OA\Get(
     *     path="/products/list",
     *     tags={"Products"},
     *     summary="Lista todos os produtos sem paginação"
     * )
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $filters = $request->all();
            $filters['per_page'] = -1; // ou 'perPage' dependendo do seu padrão

            $products = $this->service->findAll($filters);

            return response()->json([
                'data' => ProductResource::collection($products)->resolve()
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::error('Erro ao listar produtos (sem paginação)', ['exception' => $th]);
            return response()->json([
                'message' => $th->getMessage()
            ], $this->safeStatus($th));
        }
    }

    /**
     * Garante que o código HTTP usado na resposta seja válido (entre 100 e 599).
     */
    private function safeStatus(\Throwable $th): int
    {
        $code = (int) $th->getCode();
        return ($code >= 100 && $code <= 599) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;
    }
} 