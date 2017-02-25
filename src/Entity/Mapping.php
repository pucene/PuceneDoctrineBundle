<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Mapping entity.
 */
class Mapping
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Index
     */
    private $index;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection|Field[]
     */
    private $fields;

    /**
     * Test constructor.
     *
     * @param Index $index
     * @param string $name
     */
    public function __construct(Index $index, $name)
    {
        $this->index = $index;
        $this->name = $name;
        $this->fields = new ArrayCollection();
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
     * Get index.
     *
     * @return Index
     */
    public function getIndex()
    {
        return $this->index;
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

