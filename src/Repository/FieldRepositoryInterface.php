<?php

namespace Pucene\Bundle\DoctrineBundle\Repository;

use Pucene\Bundle\DoctrineBundle\Entity\Document;

interface FieldRepositoryInterface extends RepositoryInterface
{
    public function findByDocument(Document $document, $fieldName);

    public function createForDocument(Document $document, $fieldName);
}
