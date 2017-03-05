<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

interface TermRepositoryInterface extends RepositoryInterface
{
    public function findTermOrCreate($term);
}
