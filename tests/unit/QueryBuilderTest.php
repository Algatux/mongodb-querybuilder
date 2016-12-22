<?php declare(strict_types = 1);

namespace Algatux\Tests\QueryBuilder\unit;

use Algatux\QueryBuilder\QueryBuilder;
use MongoDB\Collection;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test_query_builder_construction()
    {
        $qb = new QueryBuilder($this->prophesize(Collection::class)->reveal());

        $this->assertEquals([], $qb->getQuery());
    }
}
