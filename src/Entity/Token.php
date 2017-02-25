<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

/**
 * Token entity.
 */
class Token
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var Field
     */
    private $field;

    /**
     * Token constructor.
     *
     * @param Field $field
     * @param string $value
     * @param integer $position
     */
    public function __construct(Field $field, $value, $position)
    {
        $this->field = $field;
        $this->value = $value;
        $this->position = $position;
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
     * Get field.
     *
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get position.
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}

