<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

interface DocumentRepositoryInterface extends RepositoryInterface
{
    public function findByToken($getToken);
}
