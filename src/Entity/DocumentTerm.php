<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

class DocumentTerm
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Term
     */
    private $term;

    /**
     * @var Document
     */
    private $document;

    /**
     * @var int
     */
    private $frequency = 0;

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
     * Returns term.
     *
     * @return Term
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set term.
     *
     * @param Term $term
     *
     * @return $this
     */
    public function setTerm($term)
    {
        $this->term = $term;

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
     * Returns frequency.
     *
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set frequency.
     *
     * @param int $frequency
     *
     * @return $this
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function increase()
    {
        ++$this->frequency;

        return $this;
    }
}
