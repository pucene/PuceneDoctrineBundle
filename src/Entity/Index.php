<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Index entity.
 */
class Index
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Collection|Mapping[]
     */
    private $mappings;

    /**
     * @var Collection|Document[]
     */
    private $documents;

    /**
     * Index constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->mappings = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get mappings.
     *
     * @return Collection|Mapping[]
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * Add mapping.
     *
     * @param Mapping $mapping
     *
     * @return $this
     */
    public function addMapping($mapping)
    {
        $this->mappings->add($mapping);
    }

    /**
     * Remove mapping.
     *
     * @param Mapping $mapping
     *
     * @return $this
     */
    public function removeMapping($mapping)
    {
        $this->mappings->add($mapping);
    }

    /**
     * Get documents.
     *
     * @return Collection|Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add document.
     *
     * @param Document $document
     *
     * @return $this
     */
    public function addDocument($document)
    {
        $this->documents->add($document);
    }

    /**
     * Remove document.
     *
     * @param Document $document
     *
     * @return $this
     */
    public function removeDocument($document)
    {
        $this->documents->remove($document);
    }
}

