<?php declare(strict_types = 1);

namespace Algatux\MongoDB\QueryBuilder;

use MongoDB\Collection;

/**
 * Class QueryBuilder.
 */
class QueryBuilder
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
     * QueryBuilder constructor.
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
     * Tells the query builder to execute a find
     *
     * @return $this
     */
    public function find()
    {
        return $this->setType(Query::TYPE_FIND);
    }

    /**
     * Tells the query builder to execute a count
     *
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
     * Adds and filter
     *
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
     * Adds or filter
     *
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
     * Adds eq filter
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return $this
     */
    public function equal(string $field, $value)
    {
        $this->expression->equal($field, $value);

        return $this;
    }

    /**
     * Adds ne filter
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return $this
     */
    public function notEqual(string $field, $value)
    {
        $this->expression->notEqual($field, $value);

        return $this;
    }

    /**
     * Adds in filter
     *
     * @param string $field
     * @param array  $values
     *
     * @return $this
     */
    public function in(string $field, array $values)
    {
        $this->expression->in($field, $values);

        return $this;
    }

    /**
     * Adds nin filter
     *
     * @param string $field
     * @param array  $values
     *
     * @return $this
     */
    public function notIn(string $field, array $values)
    {
        $this->expression->notIn($field, $values);

        return $this;
    }

    /**
     * Returns a new Query set up with the builder configuration
     *
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
     * Returns the query type
     *
     * @return int
     */
    public function getQueryType(): int
    {
        return $this->queryType;
    }

    /**
     * Sets the sort option
     *
     * @param array $fields
     *
     * @return $this
     */
    public function sort(array $fields)
    {
        return $this->setQueryOption('sort', $fields);
    }

    /**
     * Sets the limit option
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit)
    {
        return $this->setQueryOption('limit', $limit);
    }

    /**
     * Sets the skip(offset) option
     *
     * @param int $skip
     *
     * @return $this
     */
    public function skip(int $skip)
    {
        return $this->setQueryOption('skip', $skip);
    }

    /**
     * Sets the projection option
     *
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
     * Sets the an actually unsupported option
     * @deprecated use the right method if supported
     *
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
     * Returns a new Expression
     *
     * @return Expression
     */
    public function expr(): Expression
    {
        return new Expression();
    }
}