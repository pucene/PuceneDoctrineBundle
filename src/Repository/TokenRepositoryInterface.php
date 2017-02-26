<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Pucene\Bundle\DoctrineBundle\Entity\Document;

interface TokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $token
     *
     * @return Document[]
     */
    public function findDocuments($token);
}
