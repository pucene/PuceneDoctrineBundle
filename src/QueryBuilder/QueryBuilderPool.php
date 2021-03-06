<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

class QueryBuilderPool
{
    /**
     * @var QueryBuilderInterface[]
     */
    private $builders = [];

    /**
     * @param QueryBuilderInterface[] $builders
     */
    public function __construct(array $builders)
    {
        $this->builders = $builders;
    }

    public function get($className)
    {
        return $this->builders[$className];
    }
}
