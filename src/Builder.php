<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

use MongoDB\Collection;

/**
 * Class Builder.
 */
class Builder
{
    /** @var Collection */
    private $collection;
    /** @var Expression  */
    private $expression;
    /** @var array */
    private $options;

    /**
     * Builder constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->queryType = Query::TYPE_FIND;
        $this->expression = new Expression();
        $this->options = [];
    }

    /**
     * @return $this
     */
    public function find()
    {
        return $this->setType(Query::TYPE_FIND);
    }

    /**
     * @return $this
     */
    public function count()
    {
        return $this->setType(Query::TYPE_COUNT);
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    protected function setType(int $type)
    {
        $this->queryType = $type;

        return $this;
    }

    /**
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function and($expression)
    {
        $this->expression->and(...func_get_args());

        return $this;
    }

    /**
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function or($expression)
    {
        $this->expression->or(...func_get_args());

        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        return new Query(
            $this->collection,
            $this->queryType,
            $this->expression->getExpressionFilters(),
            $this->options
        );
    }

    /**
     * @return int
     */
    public function getQueryType(): int
    {
        return $this->queryType;
    }

    /**
     * @param array $fields
     */
    public function sort(array $fields)
    {
        $this->options['sort'] = $fields;
    }

    /**
     * @param int $limit
     */
    public function setMaxResults(int $limit)
    {
        $this->options['limit'] = $limit;
    }

    /**
     * @param array $projection
     */
    public function select(...$projection)
    {
        $this->options['projection'] = array_fill_keys($projection, 1);
    }

    /**
     * @return Expression
     */
    public function expr(): Expression
    {
        return new Expression();
    }
}