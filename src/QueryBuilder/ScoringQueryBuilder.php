<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Pucene\Bundle\DoctrineBundle\Entity\Document;

class ScoringQueryBuilder
{
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
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        $this->queryBuilder->from(Document::class, 'innerDocument')
            ->distinct()
            ->from(Document::class, 'allDocument')
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

    public function termFrequency($term)
    {
        $this->parts[] = 'SQRT(' . $this->joinTerm($term) . '.frequency)';
    }

    public function inverseDocumentFrequency($term)
    {
        // FIXME numDoc count of documents in index
        // FIXME docFreq cound of documents which contains term

        $this->parts[] = '(1+LOG10(COUNT(allDocument.id)/(' . $this->joinTerm($term) . '.frequency+1)))';
        // $this->parts[] = '1';
    }

    public function fieldLengthNorm($field)
    {
        $this->parts[] = '(1/SQRT(' . $this->joinField($field) . '.numTerms))';
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

        $this->queryBuilder->select(join(' ', $this->parts));

        $dql = $this->queryBuilder->getQuery()->getDQL();

        return $dql;
    }

    private function joinTerm($term)
    {
        $termName = 'field' . ucFirst($term);
        if (in_array($termName, $this->joins)) {
            return $termName;
        }

        $this->queryBuilder->join(
            'innerDocument.documentTerms',
            $termName,
            Join::WITH,
            $termName . '.term = \'' . $term . '\''
        );

        return $this->joins[] = $termName;
    }

    private function joinField($field)
    {
        $fieldName = 'field' . ucFirst($field);
        if (in_array($fieldName, $this->joins)) {
            return $fieldName;
        }

        $this->queryBuilder->join(
            'innerDocument.fields',
            $fieldName,
            Join::WITH,
            $fieldName . '.name = \'' . $field . '\''
        );

        return $this->joins[] = $fieldName;
    }
}

/*
SELECT 1 AS sclr_2 FROM pu_document p1_, pu_document p2_ WHERE p1_.id = '13627fd4-f777-414b-84ea-c5caea95aedb';

SELECT ((SQRT(p0_.frequency) * (1 + LOG(COUNT(p1_.id) / (p0_.frequency + 1))) * (1 / SQRT(p2_.numTerms)))) AS sclr_0
FROM pu_document p3_
	INNER JOIN pu_document_term p0_ ON p3_.id = p0_.document_id AND (p0_.term = 'geschenkten')
	INNER JOIN pu_field p2_ ON p3_.id = p2_.document_id AND (p2_.name = 'title'),
	pu_document p1_
WHERE p3_.id = '13627fd4-f777-414b-84ea-c5caea95aedb'
LIMIT 1;

SELECT SQRT(p0_.frequency) as termFrequency,
	   (1 + LOG(COUNT(p1_.id) / (p0_.frequency + 1))) as inversedDocumentFrequency,
	   (1 / SQRT(p2_.numTerms)) as fieldLengthNorm
FROM pu_document p3_
	INNER JOIN pu_document_term p0_ ON p3_.id = p0_.document_id AND (p0_.term = 'geschenkten')
	INNER JOIN pu_field p2_ ON p3_.id = p2_.document_id AND (p2_.name = 'title'),
	pu_document p1_
WHERE p3_.id = '13627fd4-f777-414b-84ea-c5caea95aedb'
LIMIT 1;
 */
