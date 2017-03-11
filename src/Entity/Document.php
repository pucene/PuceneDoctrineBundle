<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Document entity.
 */
class Document
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $indexName;

    /**
     * @var string
     */
    private $data;

    /**
     * @var Collection
     */
    private $fields;

    /**
     * @var Collection
     */
    private $documentTerms;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->documentTerms = new ArrayCollection();
    }

    /**
     * Get id.
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
     * Returns index-name.
     *
     * @return string
     */
    public function getIndexName()
    {
        return $this->indexName;
    }

    /**
     * Set index-name.
     *
     * @param string $indexName
     *
     * @return $this
     */
    public function setIndexName($indexName)
    {
        $this->indexName = $indexName;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData()
    {
        return json_decode($this->data, true);
    }

    /**
     * Set data.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = json_encode($data);

        return $this;
    }

    /**
     * Get fields.
     *
     * @return Collection|Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set fields.
     *
     * @param Collection $fields
     *
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Add field.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function addField($field)
    {
        $this->fields->add($field);

        return $this;
    }

    /**
     * Remove field.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function removeField($field)
    {
        $this->fields->add($field);

        return $this;
    }

    /**
     * Returns documentTerms.
     *
     * @return Collection
     */
    public function getDocumentTerms()
    {
        return $this->documentTerms;
    }

    /**
     * Set documentTerms.
     *
     * @param Collection $documentTerms
     *
     * @return $this
     */
    public function setDocumentTerms($documentTerms)
    {
        $this->documentTerms = $documentTerms;

        return $this;
    }
}
