<?php

namespace SparkLib\SparkQuery\Structure;

/**
 * Object for storing limit and offset of query operation. Used in LIMIT and OFFSET query
 */
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
        $this->limit = $limit;
        $this->offset =  $offset;
    }

    /** Get limit number */
    public function limit(): int
    {
        return $this->limit;
    }

    /** Get offset number */
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
            if ($limit > 0) $validLimit = $limit;
        }
        if (is_int($offset)) {
            if ($offset > 0) $validOffset = $offset;
        }
        return new Limit($validLimit, $validOffset);
    }

}
