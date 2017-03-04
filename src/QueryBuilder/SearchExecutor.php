<?php

namespace Pucene\Bundle\DoctrineBundle\QueryBuilder;

use Doctrine\ORM\EntityManagerInterface;
use Pucene\Bundle\DoctrineBundle\Entity\Document;
use Pucene\Component\QueryBuilder\Search as PuceneSearch;

class SearchExecutor
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var QueryBuilderPool
     */
    private $builders;

    /**
     * @param EntityManagerInterface $entityManager
     * @param QueryBuilderPool $builders
     */
    public function __construct(EntityManagerInterface $entityManager, QueryBuilderPool $builders)
    {
        $this->entityManager = $entityManager;
        $this->builders = $builders;
    }

    /**
     * @param PuceneSearch $search
     *
     * @return Document[]
     */
    public function execute(PuceneSearch $search)
    {
        $ormQueryBuilder = $this->entityManager->createQueryBuilder()
            ->from(Document::class, 'document')
            ->select('document')
            ->innerJoin('document.fields', 'field')
            ->innerJoin('field.tokens', 'token')
            ->setMaxResults($search->getSize())
            ->setFirstResult($search->getFrom());

        $query = $search->getQuery();
        $ormQueryBuilder->where($this->builders->get(get_class($query))->build($query, $ormQueryBuilder));

        return $ormQueryBuilder->getQuery()->getResult();
    }
}
