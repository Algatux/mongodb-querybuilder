<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

/**
 * Class Expression.
 */
class Expression
{
    /** @var array */
    private $queryPartial;

    /**
     * Expression constructor.
     */
    public function __construct()
    {
        $this->queryPartial = [];
    }

    /**
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function and($expression)
    {
        $this->prepareOperator('$and');

        $this->queryPartial['$and'] = array_merge(
            $this->queryPartial['$and'],
            array_map(
                function ($expression) {
                    return $expression instanceof Expression ? $expression->getQueryPartial() : $expression;
                },
                func_get_args()
            )
        );

        return $this;
    }

    /**
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function or($expression)
    {
        $this->prepareOperator('$or');

        $this->queryPartial['$or'] = array_merge(
            $this->queryPartial['$or'],
            array_map(
                function ($expression) {
                    return $expression instanceof Expression ? $expression->getQueryPartial() : $expression;
                },
                func_get_args()
            )
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getQueryPartial(): array
    {
        return $this->queryPartial;
    }

    /**
     * @param string $operator
     */
    private function prepareOperator(string $operator)
    {
        if (!isset($this->queryPartial[$operator])) {
            $this->queryPartial[$operator] = [];
        }
    }
}
