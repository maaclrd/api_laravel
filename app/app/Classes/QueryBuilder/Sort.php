<?php

declare(strict_types=1);

namespace App\Classes\QueryBuilder;

/**
 * Classe para manipulação da ordenação passada por parâmetro.
 */
class Sort
{
    private string $sortByField;
    private string $sortType;

    public function __construct(string $sortByField = 'id', string $sortType = 'ASC')
    {
        $this->sortByField = $sortByField;
        $this->sortType = $sortType;
    }

    /**
     * Retorna por qual campo será feita a ordenação.
     *
     * @return string
     */
    public function getByField(): string
    {
        return $this->sortByField;
    }

    /**
     * Retorna o tipo de ordenação.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->sortType;
    }

    /**
     * Formata os parâmetros para um objeto Sort.
     *
     * @param array $data
     * @param string|null $defaultSort
     * @return self
     */
    public static function formatSort(array $data, ?string $defaultSort = 'id'): self
    {
        if (isset($data['sort']) && !is_string($data['sort'])) {
            $data['sort'] = json_encode((object) $data['sort']);
        }

        $sort = !empty($data['sort']) ? json_decode($data['sort']) : null;
        $sortBy = !empty($data['sortBy']) ? $data['sortBy'] : $defaultSort;
        $sortType = !empty($data['sortType']) ? $data['sortType'] : 'ASC';

        if (!empty($sort)) {
            $sortBy = $sort->sortBy;
            $sortType = $sort->sortType;
        }

        return new self($sortBy, $sortType);
    }
}