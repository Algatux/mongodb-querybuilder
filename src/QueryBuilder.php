<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

use MongoDB\Collection;

/**
 * Class QueryBuilder
 */
class QueryBuilder
{
    /** @var Collection */
    private $collection;
    /** @var array  */
    private $query;

    /**
     * QueryBuilder constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->query = [];
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
