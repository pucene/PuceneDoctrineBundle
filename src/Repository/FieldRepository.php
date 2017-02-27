<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Doctrine\ORM\NoResultException;
use Pucene\Bundle\DoctrineBundle\Entity\Document;
use Pucene\Bundle\DoctrineBundle\Entity\Field;

class FieldRepository extends BaseRepository implements FieldRepositoryInterface
{
    public function findByDocument(Document $document, $fieldName)
    {
        $query = $this->createQueryBuilder('field')
            ->innerJoin('field.document', 'document')
            ->where('field.name = :fieldName')
            ->andWhere('document.id = :documentId')
            ->andWhere('document.indexName = :documentIndexName')
            ->setParameter('fieldName', $fieldName)
            ->setParameter('fieldName', $fieldName)
            ->setParameter('documentId', $document->getId())
            ->setParameter('documentIndexName', $document->getIndexName())
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $ex) {
            return;
        }
    }

    public function createForDocument(Document $document, $fieldName)
    {
        /** @var Field $entity */
        $entity = $this->create();
        $entity->setDocument($document);
        $entity->setName($fieldName);

        return $entity;
    }
}
