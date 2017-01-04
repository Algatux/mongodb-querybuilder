<?php declare(strict_types = 1);

namespace Algatux\MongoDB\QueryBuilder;

use MongoDB\Collection;
use MongoDB\Driver\Cursor;

/**
 * Class Query
 */
class Query
{
    const TYPE_FIND            = 1;
    const TYPE_COUNT           = 2;
    const TYPE_AGGREGATE       = 3;

    /** @var Collection */
    private $collection;
    /** @var array  */
    private $querySettings;
    /** @var array  */
    private $options;
    /** @var int */
    private $type;

    /**
     * Query constructor.
     *
     * @param Collection $collection
     * @param int        $type
     * @param array      $querySettings
     * @param array      $options
     */
    public function __construct(
        Collection $collection,
        int $type=self::TYPE_FIND,
        array $querySettings=[],
        array $options=[]
    ) {
        $this->collection = $collection;
        $this->querySettings = $querySettings;
        $this->options = $options;
        $this->type = $type;
    }

    /**
     * @return mixed|Cursor
     *
     * @throws \Exception
     */
    public function execute()
    {
        switch($this->type) {
            case self::TYPE_FIND:
                    return $this->collection->find($this->querySettings, $this->options);
                break;
            case self::TYPE_COUNT:
                    return $this->collection->count($this->querySettings, $this->options);
                break;
            case self::TYPE_AGGREGATE:
                    return $this->collection->aggregate($this->querySettings, $this->options);
                break;
            default:
                throw new \Exception('Unsupported query type ... I\'m sorry');
        }
    }

    /**
     * @return array
     */
    public function getQuerySettings(): array
    {
        return $this->querySettings;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
