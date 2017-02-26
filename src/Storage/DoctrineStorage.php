<?php

namespace Pucene\Bundle\DoctrineBundle\Storage;

use Pucene\Analysis\Token;
use Pucene\Bundle\DoctrineBundle\Entity\Document;
use Pucene\Bundle\DoctrineBundle\Entity\Token as TokenEntity;
use Pucene\Bundle\DoctrineBundle\Repository\DocumentRepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\FieldRepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\TransactionManager;
use Pucene\InvertedIndex\StorageInterface;

class DoctrineStorage implements StorageInterface
{
    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepository;

    /**
     * @var DocumentRepositoryInterface
     */
    private $documentRepository;

    /**
     * @var RepositoryInterface
     */
    private $tokenRepository;

    /**
     * @param TransactionManager $transactionManager
     * @param FieldRepositoryInterface $fieldRepository
     * @param DocumentRepositoryInterface $documentRepository
     * @param RepositoryInterface $tokenRepository
     */
    public function __construct(
        TransactionManager $transactionManager,
        FieldRepositoryInterface $fieldRepository,
        DocumentRepositoryInterface $documentRepository,
        RepositoryInterface $tokenRepository
    ) {
        $this->transactionManager = $transactionManager;
        $this->fieldRepository = $fieldRepository;
        $this->documentRepository = $documentRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function save(Token $token, array $document, $fieldName)
    {
        $this->transactionManager->start();

        /** @var Document $documentEntity */
        $documentEntity = $this->documentRepository->findOrCreate(
            [
                'indexName' => $document['_index'],
                'id' => $document['_id'],
            ]
        );
        $documentEntity->setType($document['_type']);
        $documentEntity->setData($document);

        $field = $this->fieldRepository->findByDocument($documentEntity, $fieldName);
        if (!$field) {
            $field = $this->fieldRepository->createForDocument($documentEntity, $fieldName);
        }

        /** @var TokenEntity $tokenEntity */
        $tokenEntity = $this->tokenRepository->create();
        $tokenEntity->setField($field)
            ->setToken($token->getToken())
            ->setPosition($token->getPosition())
            ->setStartOffset($token->getStartOffset())
            ->setEndOffset($token->getEndOffset())
            ->setType($token->getType());

        $this->transactionManager->add($documentEntity);
        $this->transactionManager->add($field);
        $this->transactionManager->add($tokenEntity);
        $this->transactionManager->finish();
    }

    public function getDocuments(Token $token)
    {
        return array_map(
            function (Document $document) {
                return $document->getData();
            },
            $this->documentRepository->findByToken($token->getToken())
        );
    }
}
