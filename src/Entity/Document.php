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
    private $data;

    /**
     * @var Index
     */
    private $index;

    /**
     * @var Collection
     */
    private $fields;

    /**
     * Test constructor.
     *
     * @param Index $index
     * @param string $id
     * @param string $type
     * @param string $data
     */
    public function __construct(Index $index, $id, $type, $data)
    {
        $this->index = $index;
        $this->id = $id;
        $this->type = $type;
        $this->data = $data;
        $this->fields = new ArrayCollection();
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
     * Get index.
     *
     * @return Index
     */
    public function getIndex()
    {
        return $this->index;
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
     * Add field.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function addField($field)
    {
        $this->fields->add($field);
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
    }
}

