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
    /** @var int */
    private $queryType;

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

    public function notEqual(string $field, ...$expressions)
    {
        $this->expression->notEqual($field, ...$expressions);

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
     *
     * @return $this
     */
    public function sort(array $fields)
    {
        return $this->setQueryOption('sort', $fields);
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit)
    {
        return $this->setQueryOption('limit', $limit);
    }

    /**
     * @param int $skip
     *
     * @return $this
     */
    public function skip(int $skip)
    {
        return $this->setQueryOption('skip', $skip);
    }

    /**
     * @param array $projection
     *
     * @return $this
     */
    public function select(...$projection)
    {
        $this->setQueryOption('projection', array_fill_keys($projection, 1));

        if (!in_array('_id', $projection)) {
            $this->options['projection']['_id'] = -1;
        }

        return $this;
    }

    /**
     * @param string $option
     * @param mixed  $value
     *
     * @return $this
     */
    public function setQueryOption(string $option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    /**
     * @return Expression
     */
    public function expr(): Expression
    {
        return new Expression();
    }
}