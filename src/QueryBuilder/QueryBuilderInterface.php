<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

use Doctrine\ORM\QueryBuilder;
use Pucene\Component\QueryBuilder\Query\QueryInterface;

interface QueryBuilderInterface
{
    public function build(QueryInterface $query, QueryBuilder $queryBuilder);
}
