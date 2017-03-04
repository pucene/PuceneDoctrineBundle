<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder\Query;

use Doctrine\ORM\QueryBuilder;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\QueryBuilderInterface;
use Pucene\Component\QueryBuilder\Query\QueryInterface;

class MatchAllQueryBuilder implements QueryBuilderInterface
{
    public function build(QueryInterface $query, QueryBuilder $queryBuilder)
    {
        return '1 = 1';
    }
}
