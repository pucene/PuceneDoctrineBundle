<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

interface RepositoryInterface
{
    public function find($id);

    public function findOrCreate($id);

    public function create();
}
