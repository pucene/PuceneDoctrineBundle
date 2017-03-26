<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Field entity.
 */
class Field
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Document
     */
    private $document;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $tokens;

    /**
     * @var Collection
     */
    private $fieldTerms;

    /**
     * @var int
     */
    private $numTerms = 0;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
        $this->fieldTerms = new ArrayCollection();
    }

    /**
     * Returns id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns document.
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set document.
     *
     * @param Document $document
     *
     * @return $this
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Returns name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns tokens.
     *
     * @return Collection
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Set tokens.
     *
     * @param Collection $tokens
     *
     * @return $this
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * Add token.
     *
     * @param Token $token
     *
     * @return $this
     */
    public function addToken($token)
    {
        $this->tokens->add($token);

        return $this;
    }

    /**
     * Remove token.
     *
     * @param Token $token
     *
     * @return $this
     */
    public function removeToken($token)
    {
        $this->tokens->add($token);

        return $this;
    }

    /**
     * Returns length.
     *
     * @return int
     */
    public function getNumTerms()
    {
        return $this->numTerms;
    }

    /**
     * Set length.
     *
     * @param int $numTerms
     *
     * @return $this
     */
    public function setNumTerms($numTerms)
    {
        $this->numTerms = $numTerms;

        return $this;
    }

    public function increase()
    {
        ++$this->numTerms;

        return $this;
    }

    /**
     * Returns fieldTerms.
     *
     * @return Collection
     */
    public function getFieldTerms()
    {
        return $this->fieldTerms;
    }

    /**
     * Set fieldTerms.
     *
     * @param Collection $fieldTerms
     *
     * @return $this
     */
    public function setFieldTerms($fieldTerms)
    {
        $this->fieldTerms = $fieldTerms;

        return $this;
    }
}
