<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder\Query\TermLevel;

use Doctrine\ORM\QueryBuilder;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\QueryBuilderInterface;
use Pucene\Component\QueryBuilder\Query\QueryInterface;
use Pucene\Component\QueryBuilder\Query\TermLevel\Term;

class TermQueryBuilder implements QueryBuilderInterface
{
    private $index = 0;

    /**
     * {@inheritdoc}
     *
     * @param Term $query
     */
    public function build(QueryInterface $query, QueryBuilder $queryBuilder)
    {
        $currentIndex = $this->index++;

        $queryBuilder->setParameter('fieldName_' . $currentIndex, $query->getField());
        $queryBuilder->setParameter('term_' . $currentIndex, $query->getTerm());

        return $queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('term.term', ':term_' . $currentIndex),
            $queryBuilder->expr()->eq('field.name', ':fieldName_' . $currentIndex)
        );
    }
}
