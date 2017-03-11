<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder\Query\FullText;

use Doctrine\ORM\QueryBuilder;
use Pucene\Analysis\AnalyzerInterface;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\Query\TermLevel\TermQueryBuilder;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\QueryBuilderInterface;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\ScoringQueryBuilder;
use Pucene\Component\QueryBuilder\Query\FullText\Match;
use Pucene\Component\QueryBuilder\Query\QueryInterface;
use Pucene\Component\QueryBuilder\Query\TermLevel\Term;

class MatchQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var AnalyzerInterface
     */
    private $analyzer;

    /**
     * @var TermQueryBuilder
     */
    private $termQueryBuilder;

    /**
     * @param AnalyzerInterface $analyzer
     * @param TermQueryBuilder $termQueryBuilder
     */
    public function __construct(AnalyzerInterface $analyzer, TermQueryBuilder $termQueryBuilder)
    {
        $this->analyzer = $analyzer;
        $this->termQueryBuilder = $termQueryBuilder;
    }

    /**
     * {@inheritdoc}
     *
     * @param Match $query
     */
    public function build(QueryInterface $query, QueryBuilder $queryBuilder, ScoringQueryBuilder $scoringQueryBuilder)
    {
        $tokens = $this->analyzer->analyze($query->getQuery());

        $scoringQueryBuilder->open();

        $or = $queryBuilder->expr()->orX();
        foreach ($tokens as $token) {
            $scoringQueryBuilder->open();

            $or->add(
                $this->termQueryBuilder->build(
                    new Term($query->getField(), $token->getTerm()),
                    $queryBuilder,
                    $scoringQueryBuilder
                )
            );

            $scoringQueryBuilder->close();
        }

        $scoringQueryBuilder->close();

        return $or;
    }
}
