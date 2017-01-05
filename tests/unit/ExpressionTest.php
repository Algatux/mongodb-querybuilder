<?php declare(strict_types = 1);

namespace Algatux\MongoDB\Tests\QueryBuilderunit;

use Algatux\MongoDB\QueryBuilder\Expression;

class ExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function test_and_filters()
    {
        $exp = new Expression();
        $exp->and(["testField" => 10]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField" => 10 ]
                ]
            ],
            $exp->getExpressionFilters()
        );
    }

    public function test_and_multiple_filters()
    {
        $exp = new Expression();
        $exp->and(["testField1" => 1]);
        $exp->and(["testField2" => 2]);
        $exp->and(["testField3" => 3]);

        $this->assertEquals(
            [
                '$and' => [
                    [ "testField1" => 1 ],
                    [ "testField2" => 2 ],
                    [ "testField3" => 3 ],
                ]
            ],
            $exp->getExpressionFilters()
        );
    }

    public function test_equal()
    {
        $exp = new Expression();
        $exp->equal('testF', 10);

        $this->assertEquals(
            [
                'testF' => ['$eq' => 10],
            ],
            $exp->getExpressionFilters()
        );
    }

    public function test_notEqual()
    {
        $exp = new Expression();
        $exp->notEqual('testF', 10);

        $this->assertEquals(
            [
                'testF' => ['$ne' => 10],
            ],
            $exp->getExpressionFilters()
        );
    }

    public function test_in()
    {
        $exp = new Expression();
        $exp->in('testF', [1,2,3]);

        $this->assertEquals(
            [
                'testF' => ['$in' => [1,2,3]],
            ],
            $exp->getExpressionFilters()
        );
    }

    public function test_nin()
    {
        $exp = new Expression();
        $exp->notIn('testF', [1,2,3]);

        $this->assertEquals(
            [
                'testF' => ['$nin' => [1,2,3]],
            ],
            $exp->getExpressionFilters()
        );
    }

}
