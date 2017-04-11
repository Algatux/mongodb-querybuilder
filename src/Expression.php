<?php declare(strict_types = 1);

namespace Algatux\MongoDB\QueryBuilder;

/**
 * Class Expression.
 */
class Expression
{
    /** @var array */
    private $filters;

    /**
     * Expression constructor.
     */
    public function __construct()
    {
        $this->filters = [];
    }

    /**
     * Adds and filter
     *
     * @param array|Expression $expression
     *
     * @return $this|Expression
     */
    public function and($expression): Expression
    {
        $this->prepareFilterIndex('$and');

        $this->filters['$and'] = array_merge(
            $this->filters['$and'],
            $this->mapExpressions(...func_get_args())
        );

        return $this;
    }

    /**
     * @param string $operator
     */
    private function prepareFilterIndex(string $operator)
    {
        if (!isset($this->filters[$operator])) {
            $this->filters[$operator] = [];
        }
    }

    /**
     * @param  $expressions
     *
     * @return array
     */
    private function mapExpressions($expressions): array
    {
        return array_map(
            function ($expression) {
                return $expression instanceof Expression ? $expression->getExpressionFilters() : $expression;
            },
            func_get_args()
        );
    }

    /**
     * Returns the filters generated by the expression
     *
     * @return array
     */
    public function getExpressionFilters(): array
    {
        return $this->filters;
    }

    /**
     * Adds or filter
     *
     * @param array|Expression $expression
     *
     * @return $this|Expression
     */
    public function or ($expression): Expression
    {
        $this->prepareFilterIndex('$or');

        $this->filters['$or'] = array_merge(
            $this->filters['$or'],
            $this->mapExpressions(...func_get_args())
        );

        return $this;
    }

    /**
     * Adds eq filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */
    public function equal(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$eq', $value);

        return $this;
    }

    /**
     * Adds ne filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */
    public function notEqual(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$ne', $value);

        return $this;
    }

    /**
     * Adds gt filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */

    public function greaterThan(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$gt', $value);

        return $this;
    }

    /**
     * Adds gte filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */

    public function greaterEqualThan(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$gte', $value);

        return $this;
    }

    /**
     * Adds lt filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */

    public function lowerThan(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$lt', $value);

        return $this;
    }

    /**
     * Adds lte filter
     *
     * @param string $field
     * @param string $value
     *
     * @return $this|Expression
     */

    public function lowerEqualThan(string $field, $value): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$lte', $value);

        return $this;
    }

    /**
     * Adds in filter
     *
     * @param string $field
     * @param array  $values
     *
     * @return $this|Expression
     */
    public function in(string $field, array $values): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$in', $values);

        return $this;
    }

    /**
     * Adds notIn filter
     *
     * @param string $field
     * @param array  $values
     *
     * @return $this|Expression
     */
    public function notIn(string $field, array $values): Expression
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$nin', $values);

        return $this;
    }


    /**
     * @param string $operation
     * @param mixed  $value
     *
     * @return array
     */
    private function operationExpression(string $operation, $value): array
    {
        return [$operation => $value];
    }
}
