<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

class TermRepository extends BaseRepository implements TermRepositoryInterface
{
    public function findTermOrCreate($term)
    {
        $termEntity = $this->findOneBy(['term' => $term]);
        if (!$termEntity) {
            $termEntity = $this->create();
            $termEntity->setTerm($term);
        }

        return $termEntity;
    }
}
