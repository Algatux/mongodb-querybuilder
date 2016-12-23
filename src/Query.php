<?php declare(strict_types = 1);

namespace Algatux\QueryBuilder;

use MongoDB\Collection;
use MongoDB\Driver\Cursor;

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
    private $filters;
    /** @var array  */
    private $options;
    /** @var int */
    private $type;

    /**
     * Query constructor.
     *
     * @param Collection $collection
     * @param int        $type
     * @param array      $filters
     * @param array      $options
     */
    public function __construct(Collection $collection, int $type=self::TYPE_FIND, array $filters=[], array $options=[])
    {
        $this->collection = $collection;
        $this->filters = $filters;
        $this->options = $options;
        $this->type = $type;
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
                    return $this->collection->find($this->filters, $this->options);
                break;
            case self::TYPE_COUNT:
                    return $this->collection->count($this->filters, $this->options);
                break;
            default:
                throw new \Exception('Unsupported query type ... I\'m sorry');
        }
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
