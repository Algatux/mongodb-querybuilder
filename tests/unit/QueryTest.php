<?php declare(strict_types = 1);

namespace Algatux\Tests\QueryBuilder\unit;

use Algatux\QueryBuilder\Query;
use MongoDB\Collection;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function test_query_construction()
    {
        $qb = new Query($this->prophesize(Collection::class)->reveal());

        $this->assertEquals([], $qb->getQuery());
    }
}
