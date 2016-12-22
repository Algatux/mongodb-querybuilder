<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

use MongoDB\Collection;

/**
 * Class Query
 */
class Query
{
    const TYPE_FIND            = 1;
    const TYPE_FIND_AND_UPDATE = 2;
    const TYPE_FIND_AND_REMOVE = 3;
    const TYPE_INSERT          = 4;
    const TYPE_UPDATE          = 5;
    const TYPE_REMOVE          = 6;
    const TYPE_GROUP           = 7;
    const TYPE_MAP_REDUCE      = 8;
    const TYPE_DISTINCT        = 9;
    const TYPE_GEO_NEAR        = 10;
    const TYPE_COUNT           = 11;

    /** @var Collection */
    private $collection;
    /** @var array  */
    private $query;
    /** @var array  */
    private $options;
    /** @var int */
    private $type;

    /**
     * Query constructor.
     *
     * @param Collection $collection
     * @param array      $query
     * @param array      $options
     */
    public function __construct(Collection $collection, array $query = [], array $options = [])
    {
        $this->collection = $collection;
        $this->query = $query;
        $this->options = $options;
        $this->type = $query['type'] ?? self::TYPE_FIND;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function execute()
    {
        switch($this->type) {
            case self::TYPE_FIND:
                    return $this->collection->find($this->query, $this->options);
                break;
            default:
                throw new \Exception('Unsupported query type ... I\'m sorry');
        }
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
