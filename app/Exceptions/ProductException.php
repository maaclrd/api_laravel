<?php

namespace App\Exceptions;

class ProductException extends \Exception
{
    public static function notFound(int $id): self
    {
        return new self("Produto #{$id} não encontrado", 404);
    }

    public static function createFailed(string $message): self
    {
        return new self("Erro ao criar produto: {$message}", 422);
    }

    public static function updateFailed(string $message): self
    {
        return new self("Erro ao atualizar produto: {$message}", 422);
    }

    public static function duplicateEntry(string $field = ''): self
    {
        return new self(
            $field
                ? "Já existe um produto com o campo '{$field}' informado"
                : "Já existe um produto com os dados informados",
            422
        );
    }
} 