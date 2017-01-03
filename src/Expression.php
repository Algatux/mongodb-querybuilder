<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

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
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function and ($expression)
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
     * @return array
     */
    public function getExpressionFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array|Expression $expression
     *
     * @return $this
     */
    public function or ($expression)
    {
        $this->prepareFilterIndex('$or');

        $this->filters['$or'] = array_merge(
            $this->filters['$or'],
            $this->mapExpressions(...func_get_args())
        );

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return $this
     */
    public function equal(string $field, $value)
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$eq', $value);

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

    /**
     * @param string $field
     * @param string $value
     *
     * @return $this
     */
    public function notEqual(string $field, $value)
    {
        $this->prepareFilterIndex($field);

        $this->filters[$field] = $this->operationExpression('$ne', $value);

        return $this;
    }
}
