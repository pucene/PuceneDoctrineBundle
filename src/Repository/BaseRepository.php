<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;

class BaseRepository extends EntityRepository implements RepositoryInterface
{
    public function findOrCreate($id)
    {
        $entity = $this->find($id);
        if (!$entity) {
            $entity = $this->create();

            if (is_array($id)) {
                $accessor = PropertyAccess::createPropertyAccessor();

                foreach ($id as $idKey => $idValue) {
                    $accessor->setValue($entity, $idKey, $idValue);
                }
            } else {
                $entity->setId($id);
            }
        }

        return $entity;
    }

    public function create()
    {
        return new $this->_entityName();
    }

    public function remove($id)
    {
        $entity = $this->find($id);
        if (!$entity) {
            return;
        }

        $this->_em->remove($entity);
    }
}
