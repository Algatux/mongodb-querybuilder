<?php declare(strict_types = 1);

namespace Algatux\MongoDB\Tests\QueryBuilder\functional;

use Algatux\MongoDB\QueryBuilder\QueryBuilder;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;

/**
 * Class TestCase
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    const TEST_DATABASE = 'test_execution_database';
    const TEST_COLLECTION = 'test_execution_collection';

    /** @var Database */
    private $database;
    /** @var Collection */
    private $collection;

    protected function setUp()
    {
        $client = new Client();
        $this->database = $client->selectDatabase(self::TEST_DATABASE);
        $this->collection = $this->database->selectCollection(self::TEST_COLLECTION);
        $this->prepareFixtures();
    }

    protected function tearDown()
    {
        $this->database->dropCollection(self::TEST_COLLECTION);
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->collection);
    }

    protected function prepareFixtures()
    {
        $this->collection->insertMany([
            // Doc1
            [
                'name' => 'Alessandro',
                'surname' => 'Galli',
                'age' => 31,
                'type' => 'Developer'
            ],
            // Doc2
            [
                'name' => 'John',
                'surname' => 'Snow',
                'age' => 24,
                'type' => 'Fantasy Character'
            ],
            // Doc3
            [
                'name' => 'James',
                'surname' => 'Hetfield',
                'age' => 45,
                'type' => 'Musician'
            ],
        ]);
    }
}