<?php

namespace Pucene\Bundle\DoctrineBundle\Storage;

use Pucene\Analysis\Token;
use Pucene\Bundle\DoctrineBundle\Entity\Document;
use Pucene\Bundle\DoctrineBundle\Entity\DocumentTerm;
use Pucene\Bundle\DoctrineBundle\Entity\Field;
use Pucene\Bundle\DoctrineBundle\Entity\Term;
use Pucene\Bundle\DoctrineBundle\Entity\Token as TokenEntity;
use Pucene\Bundle\DoctrineBundle\QueryBuilder\SearchExecutor;
use Pucene\Bundle\DoctrineBundle\Repository\DocumentRepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\FieldRepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\TermRepositoryInterface;
use Pucene\Bundle\DoctrineBundle\Repository\TransactionManager;
use Pucene\Component\QueryBuilder\Search;
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
     * @var TermRepositoryInterface
     */
    private $termRepository;

    /**
     * @var RepositoryInterface
     */
    private $documentTermRepository;

    /**
     * @var SearchExecutor
     */
    private $searchExecutor;

    /**
     * @param TransactionManager $transactionManager
     * @param FieldRepositoryInterface $fieldRepository
     * @param DocumentRepositoryInterface $documentRepository
     * @param RepositoryInterface $tokenRepository
     * @param TermRepositoryInterface $termRepository
     * @param RepositoryInterface $documentTermRepository
     * @param SearchExecutor $searchExecutor
     */
    public function __construct(
        TransactionManager $transactionManager,
        FieldRepositoryInterface $fieldRepository,
        DocumentRepositoryInterface $documentRepository,
        RepositoryInterface $tokenRepository,
        TermRepositoryInterface $termRepository,
        RepositoryInterface $documentTermRepository,
        SearchExecutor $searchExecutor
    ) {
        $this->transactionManager = $transactionManager;
        $this->fieldRepository = $fieldRepository;
        $this->documentRepository = $documentRepository;
        $this->tokenRepository = $tokenRepository;
        $this->termRepository = $termRepository;
        $this->documentTermRepository = $documentTermRepository;
        $this->searchExecutor = $searchExecutor;
    }

    public function beginSaveDocument()
    {
        $this->transactionManager->start();
    }

    public function save(Token $token, array $document, $fieldName)
    {
        /** @var Document $documentEntity */
        $documentEntity = $this->documentRepository->findOrCreate($document['_id']);
        $documentEntity->setType($document['_type']);
        $documentEntity->setData($document);

        /** @var Field $field */
        $field = $this->fieldRepository->findOrCreate($documentEntity->getId() . '-' . $fieldName);
        $field->setName($fieldName);
        $field->setDocument($documentEntity);
        $field->increase();

        /** @var Term $term */
        $term = $this->termRepository->findOrCreate($token->getTerm());

        /** @var DocumentTerm $termFrequency */
        $termFrequency = $this->documentTermRepository->findOrCreate($documentEntity->getId() . '-' . $term->getTerm());
        $termFrequency->setDocument($documentEntity);
        $termFrequency->setTerm($term);
        $termFrequency->increase();

        /** @var TokenEntity $tokenEntity */
        $tokenEntity = $this->tokenRepository->create();
        $tokenEntity->setField($field)
            ->setTerm($term)
            ->setPosition($token->getPosition())
            ->setStartOffset($token->getStartOffset())
            ->setEndOffset($token->getEndOffset())
            ->setType($token->getType());

        $this->transactionManager->add($documentEntity);
        $this->transactionManager->add($field);
        $this->transactionManager->add($term);
        $this->transactionManager->add($tokenEntity);
        $this->transactionManager->add($termFrequency);
    }

    public function finishSaveDocument()
    {
        $this->transactionManager->finish();
    }

    public function search(Search $search)
    {
        $result = $this->searchExecutor->execute($search);

        return array_map(
            function ($document) {
                $data = json_decode($document['data'], true);
                $data['_scoring'] = $document['scoring'];

                return $data;
            },
            $result
        );
    }

    public function remove($id)
    {
        $this->transactionManager->start();
        $this->documentRepository->remove($id);
        $this->transactionManager->finish();
    }
}
