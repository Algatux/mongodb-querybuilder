<?php declare(strict_types = 1);

namespace Algatux\Tests\QueryBuilder\functional;

class QueryExcetutionTest extends TestCase
{
    public function test_and()
    {
        $builder = $this->getQueryBuilder();

        $res = $builder->and(
            ['name' => 'Alessandro'],
            ['age' => 31]
        )
            ->find()
            ->getQuery()
            ->execute()
            ->toArray();

        $this->assertCount(1, $res);
        $this->assertEquals('Alessandro', $res[0]->name);
        $this->assertEquals(31, $res[0]->age);
    }

    public function test_or()
    {
        $builder = $this->getQueryBuilder();

        $res = $builder->or(
            ['name' => 'John'],
            ['name' => 'James']
        )
            ->find()
            ->getQuery()
            ->execute()
            ->toArray();

        $this->assertCount(2, $res);
        $this->assertEquals('John', $res[0]->name);
        $this->assertEquals('James', $res[1]->name);
    }
}
