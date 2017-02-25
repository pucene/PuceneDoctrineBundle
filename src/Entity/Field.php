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
     * @var Mapping
     */
    private $mapping;

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
     * Field constructor.
     *
     * @param Document $document
     * @param Mapping $mapping
     * @param string $name
     */
    public function __construct(Document $document, Mapping $mapping, $name)
    {
        $this->document = $document;
        $this->mapping = $mapping;
        $this->name = $name;
        $this->tokens = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get document.
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get mapping.
     *
     * @return Mapping
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get tokens.
     *
     * @return Collection|Token[]
     */
    public function getTokens()
    {
        return $this->tokens;
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
    }
}

