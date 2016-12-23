<?php declare(strict_types = 1);

namespace Algatux\Tests\QueryBuilder\unit;

use Algatux\QueryBuilder\Builder;
use Algatux\QueryBuilder\Query;
use MongoDB\Collection;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test_and_array()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder
            ->count()
            ->and(['testField' => 10]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField" => 10 ]
                ]
            ],
            $builder->getQuery()->getFilters()
        );
        $this->assertEquals(Query::TYPE_COUNT, $builder->getQueryType());
    }

    public function test_and_multiple_array()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder
            ->find()
            ->and(['testField1' => 1])
            ->and(['testField2' => 2]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField1" => 1 ],
                    [ "testField2" => 2 ],
                ]
            ],
            $builder->getQuery()->getFilters()
        );
        $this->assertEquals(Query::TYPE_FIND, $builder->getQueryType());
    }

    public function test_and_multiple_array_single_call()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->and(['testField1' => 1],['testField2' => 2]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField1" => 1 ],
                    [ "testField2" => 2 ],
                ]
            ],
            $builder->getQuery()->getFilters()
        );
    }

    public function test_expressions_concatenation_and()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->and(
            $builder->expr()->or(
                ['testField1' => ['$in' => ['a', 'b']]],
                ['testField2' => 2]
            ),
            ['testField3' => 3]
        );

        $this->assertEquals(
            [
                '$and' => [
                    [
                        '$or' => [
                            ["testField1" => ['$in' => ['a', 'b']]] ,
                            ['testField2' => 2]
                        ]
                    ],
                    ['testField3' => 3]
                ]
            ],
            $builder->getQuery()->getFilters()
        );
    }

    public function test_expressions_concatenation_or()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->or(
            $builder->expr()->and(
                ['testField1' => ['$in' => ['a', 'b']]],
                ['testField2' => 2]
            ),
            ['testField3' => 3]
        );

        $this->assertEquals(
            [
                '$or' => [
                    [
                        '$and' => [
                            ["testField1" => ['$in' => ['a', 'b']]] ,
                            ['testField2' => 2]
                        ]
                    ],
                    ['testField3' => 3]
                ]
            ],
            $builder->getQuery()->getFilters()
        );
    }

    public function test_sort()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->sort(['sortField' => -1]);

        $this->assertEquals(
            ['sort' => ['sortField' => -1]],
            $builder->getQuery()->getOptions()
        );
    }

    public function test_limit()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->setMaxResults(10);

        $this->assertEquals(
            ['limit' => 10],
            $builder->getQuery()->getOptions()
        );
    }

    public function test_projection()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->select('_id', 'field1');

        $this->assertEquals(
            ['projection' => ['_id' => 1, 'field1' => 1]],
            $builder->getQuery()->getOptions()
        );
    }
}