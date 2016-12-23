<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

use MongoDB\Collection;

/**
 * Class Builder.
 */
class Builder
{
    const COND_TYPE_AND = 1;
    const COND_TYPE_OR = 1;

    /** @var Collection */
    private $collection;
    /** @var Expression  */
    private $expression;

    /**
     * Builder constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->expression = new Expression();
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
     * @return array
     */
    public function getQueryFilters(): array
    {
        return $this->expression->getQueryPartial();
    }

    /**
     * @return Expression
     */
    public function expr(): Expression
    {
        return new Expression();
    }
}