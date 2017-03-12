<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Pucene\Bundle\DoctrineBundle\Entity\Document;

class ScoringQueryBuilder
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var string[]
     */
    private $parts = [];

    /**
     * @var string[]
     */
    private $joins = [];

    /**
     * @var int
     */
    private $docCount;

    /**
     * @var int[]
     */
    private $docCountPerTerm = [];

    /**
     * @param EntityManagerInterface $entityManager
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(EntityManagerInterface $entityManager, QueryBuilder $queryBuilder)
    {
        $this->entityManager = $entityManager;
        $this->queryBuilder = $queryBuilder;

        $this->queryBuilder->from(Document::class, 'innerDocument')
            ->where('innerDocument.id = document.id')
            ->setMaxResults(1);
    }

    public function open()
    {
        $this->parts[] = '(';
    }

    public function multiply()
    {
        $this->parts[] = '*';
    }

    public function addition()
    {
        $this->parts[] = '+';
    }

    public function queryNorm(array $tokens)
    {
        $sum = 0;
        foreach ($tokens as $token) {
            $sum += pow($this->calculateInverseDocumentFrequency($token->getTerm()), 2);
        }

        $this->parts[] = (1.0 / sqrt($sum));
    }

    public function termFrequency($term)
    {
        $this->parts[] = 'COALESCE(SQRT(' . $this->joinTerm($term) . '.frequency),0)';
    }

    public function inverseDocumentFrequency($term)
    {
        $this->parts[] = $this->calculateInverseDocumentFrequency($term);
    }

    private function calculateInverseDocumentFrequency($term)
    {
        return 1 + log((float) $this->getDocCount() / (float) ($this->getDocCountPerTerm($term) + 1));
    }

    public function fieldLengthNorm($field)
    {
        $this->parts[] = 'COALESCE((1/SQRT(' . $this->joinField($field) . '.numTerms)),0)';
    }

    public function close()
    {
        $this->parts[] = ')';
    }

    public function getDQL()
    {
        if (count($this->parts) === 0) {
            $this->parts[] = '1';
        }

        $this->queryBuilder->select(implode(' ', $this->parts));

        $dql = $this->queryBuilder->getQuery()->getDQL();

        return $dql;
    }

    private function joinTerm($term)
    {
        $termName = 'field' . ucfirst($term);
        if (in_array($termName, $this->joins)) {
            return $termName;
        }

        $this->queryBuilder
            ->leftJoin('innerDocument.documentTerms', $termName, Join::WITH, $termName . '.term = \'' . $term . '\'');

        return $this->joins[] = $termName;
    }

    private function joinField($field)
    {
        $fieldName = 'field' . ucfirst($field);
        if (in_array($fieldName, $this->joins)) {
            return $fieldName;
        }

        $this->queryBuilder
            ->leftJoin('innerDocument.fields', $fieldName, Join::WITH, $fieldName . '.name = \'' . $field . '\'');

        return $this->joins[] = $fieldName;
    }

    private function getDocCount()
    {
        if ($this->docCount) {
            return $this->docCount;
        }

        $queryBuilder = $this->entityManager->createQueryBuilder()->select('COUNT(document.id)')->from(
            Document::class,
            'document'
        );

        return $this->docCount = (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    private function getDocCountPerTerm($term)
    {
        if (array_key_exists($term, $this->docCountPerTerm)) {
            return $this->docCountPerTerm[$term];
        }

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('COUNT(document.id)')
            ->from(Document::class, 'document')
            ->leftJoin('document.documentTerms', 'documentTerm')
            ->leftJoin('documentTerm.term', 'term', Join::WITH, 'term.term = :term')
            ->setParameter('term', $term);

        return $this->docCountPerTerm[$term] = (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
