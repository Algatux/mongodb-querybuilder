<?php declare(strict_types = 1);

namespace Algatux\Tests\QueryBuilder\unit;

use Algatux\QueryBuilder\Builder;
use MongoDB\Collection;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test_and_array()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->and(['testField' => 10]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField" => 10 ]
                ]
            ],
            $builder->getQuery()->getFilters()
        );
    }

    public function test_and_multiple_array()
    {
        $builder = new Builder($this->prophesize(Collection::class)->reveal());

        $builder->and(['testField1' => 1]);
        $builder->and(['testField2' => 2]);

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
}