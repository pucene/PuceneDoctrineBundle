<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;

class TransactionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function start()
    {
        $this->entityManager->beginTransaction();
    }

    public function add($entity)
    {
        $this->entityManager->persist($entity);
    }

    public function finish()
    {
        try {
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->rollback();

            throw $e;
        }
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }
}
