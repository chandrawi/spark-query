<?php

namespace SparkLib\SparkQuery\Structure;

class Limit
{

    /**
     * Limit
     */
    private $limit;

    /**
     * Offset
     */
    private $offset;

    /** Not set constant */
    public const NOT_SET = -1;

    /**
     * Constructor. Set limit and offset
     */
    public function __construct(int $limit, int $offset)
    {
        $this->limit = ($limit >= 0) ? $limit : self::NOT_SET ;
        $this->offset = ($offset >= 0) ? $offset : self::NOT_SET ;
    }

    /** Get limit */
    public function limit(): int
    {
        return $this->limit;
    }

    /** Get offset */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * Create Limit object from input limit and offset for LIMIT query
     */
    public static function create($limit, $offset): Limit
    {
        $validLimit = Limit::NOT_SET;
        $validOffset = Limit::NOT_SET;
        if (is_int($limit)) {
            if ($limit > 0) $validLimit = $offset;
        }
        if (is_int($offset)) {
            if ($offset > 0) $validOffset = $offset;
        }
        return new Limit($validLimit, $validOffset);
    }

}
