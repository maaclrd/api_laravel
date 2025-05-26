<?php

declare(strict_types=1);

namespace App\Classes\QueryBuilder;

/**
 * Classe para manipulação dos filtros passados por parâmetros.
 */
class Filter
{
    /**
     * Indica se há filtros ativos.
     *
     * @var bool
     */
    protected $hasFilters = false;

    /**
     * @var array|null
     */
    protected $filters = null;

    /**
     * Construtor responsável por criar os atributos da classe.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        foreach ($filters as $filterName => $value) {
            if (is_null($value)) {
                continue;
            }

            $this->hasFilters = true;
            $this->{$filterName} = $value;
        }
    }

    /**
     * Retorna se possui filtros.
     *
     * @return bool
     */
    public function hasFilters(): bool
    {
        return $this->hasFilters;
    }

    /**
     * Formata os parâmetros para um objeto Filter.
     *
     * @param mixed $data
     * @return self
     */
    public static function formatFilters($data): self
    {
        $filter = !empty($data['filter']) ? $data['filter'] : null;

        if (empty($filter)) {
            return new self();
        }

        if (is_array($filter)) {
            return new self($filter);
        }

        $filter = json_decode($filter);

        $filters = [];
        foreach ($filter as $filterName => $value) {
            $filters[$filterName] = $value;
        }

        return new self($filters);
    }

    /**
     * Retorna o valor de um filtro pelo nome.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->$key ?? null;
    }
}