<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    public function findByToken($token)
    {
        $query = $this->createQueryBuilder('document')
            ->innerJoin('document.fields', 'field')
            ->innerJoin('field.tokens', 'token')
            ->where('token.token = :token')
            ->setParameter('token', $token)
            ->getQuery();

        return $query->getResult();
    }
}
