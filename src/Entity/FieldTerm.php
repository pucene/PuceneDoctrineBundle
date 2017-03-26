<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

/**
 * Contains statistic between field and term.
 */
class FieldTerm
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
     * @var Field
     */
    private $field;

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
     * Returns field.
     *
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set field.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

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
