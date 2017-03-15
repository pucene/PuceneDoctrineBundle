<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Pucene\Analysis\Token;
use Pucene\Bundle\DoctrineBundle\Entity\Document;
use Pucene\Bundle\DoctrineBundle\Entity\DocumentTerm;

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
        $terms = array_map(
            function (Token $token) {
                return $token->getTerm();
            },
            $tokens
        );

        $sum = 0;
        foreach ($this->getDocCountPerTerms($terms) as $term => $value) {
            $sum += pow($this->calculateInverseDocumentFrequency($value), 2);
        }

        $this->parts[] = (1.0 / sqrt($sum));
    }

    public function coord($field, array $tokens)
    {
        $sum = [];
        foreach ($tokens as $token) {
            $sum[] = 'COUNT(' . $this->joinTerm($field, $token->getTerm()) . ')';
        }

        $this->parts[] = '((' . implode('+', $sum) . ')/' . count($tokens) . ')';
    }

    public function termFrequency($field, $term)
    {
        $this->parts[] = 'COALESCE(SQRT(COUNT(' . $this->joinTerm($field, $term) . '.id)),0)';
    }

    public function inverseDocumentFrequency($term)
    {
        $this->parts[] = $this->calculateInverseDocumentFrequency($this->getDocCountPerTerm($term));
    }

    private function calculateInverseDocumentFrequency($docCount)
    {
        return 1 + log((float)$this->getDocCount() / ($docCount + 1));
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

    private function joinTerm($field, $term)
    {
        $termName = 'field' . ucfirst($term);
        if (in_array($termName, $this->joins)) {
            return $termName;
        }

        $this->queryBuilder->leftJoin(
            $this->joinField($field) . '.fieldTerms',
            $termName,
            Join::WITH,
            $termName . '.term = \'' . $term . '\''
        );

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

    private function getDocCountPerTerms(array $terms)
    {
        // TODO reuse doc-counts.

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('COUNT(document.id)')
            ->addSelect('term.term')
            ->from(DocumentTerm::class, 'documentTerm')
            ->leftJoin('documentTerm.document', 'document')
            ->leftJoin('documentTerm.term', 'term')
            ->where('term.term IN (:terms)')
            ->groupBy('term.term')
            ->setParameter('terms', $terms);

        $result = [];
        foreach ($queryBuilder->getQuery()->getArrayResult() as $item) {
            $result[$item['term']] = $item[1];
            $this->docCountPerTerm[$item['term']] = $item[1];
        }

        return $result;
    }
}
