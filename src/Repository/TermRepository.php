<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

class TermRepository extends BaseRepository implements TermRepositoryInterface
{
    public function findOrCreate($id)
    {
        $entity = $this->find($id);
        if (!$entity) {
            $entity = $this->create();
            $entity->setTerm($id);
        }

        return $entity;
    }
}
