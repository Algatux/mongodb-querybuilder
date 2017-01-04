<?php declare(strict_types = 1);

namespace Algatux\MongoDB\Tests\QueryBuilderunit;

use Algatux\MongoDB\QueryBuilder\Query;
use MongoDB\Collection;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function test_query_unsupported()
    {
        $coll = $this->prophesize(Collection::class);

        $qb = new Query($coll->reveal(), 999);
        $this->expectException(\Exception::class);
        $qb->execute();
    }

    public function test_query_find_execution()
    {
        $coll = $this->prophesize(Collection::class);
        $coll->find([],[])->shouldBeCalledTimes(1);

        $qb = new Query($coll->reveal());
        $qb->execute();

        $this->assertEquals([], $qb->getQuerySettings());
        $this->assertEquals([], $qb->getOptions());
    }

    public function test_query_count_execution()
    {
        $coll = $this->prophesize(Collection::class);
        $coll->count(['filter'=>1],['option' => 1])->shouldBeCalledTimes(1);

        $qb = new Query($coll->reveal(), Query::TYPE_COUNT, ['filter'=>1], ['option' => 1]);
        $qb->execute();

        $this->assertEquals(['filter'=>1], $qb->getQuerySettings());
        $this->assertEquals(['option' => 1], $qb->getOptions());
    }

    public function test_query_aggregate_execution()
    {
        $coll = $this->prophesize(Collection::class);
        $coll->aggregate(['filter'=>1],['option' => 1])->shouldBeCalledTimes(1);

        $qb = new Query($coll->reveal(), Query::TYPE_AGGREGATE, ['filter'=>1], ['option' => 1]);
        $qb->execute();

        $this->assertEquals(['filter'=>1], $qb->getQuerySettings());
        $this->assertEquals(['option' => 1], $qb->getOptions());
    }
}
