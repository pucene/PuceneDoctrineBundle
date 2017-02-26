<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Pucene\Bundle\DoctrineBundle\Entity\Token;

class TokenRepository extends BaseRepository implements TokenRepositoryInterface
{
    public function findDocuments($token)
    {
        $query = $this->createQueryBuilder('token')
            ->innerJoin('token.field', 'field')
            ->innerJoin('field.document', 'document')
            ->where('token.token = :token')
            ->setParameter('token', $token)
            ->getQuery();

        return array_map(
            function (Token $token) {
                return $token->getField()->getDocument();
            },
            $query->getResult()
        );
    }
}
