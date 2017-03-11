<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

class Term
{
    /**
     * @var string
     */
    private $term;

    /**
     * @var int
     */
    private $frequency = 0;

    /**
     * Returns term.
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set term.
     *
     * @param string $term
     *
     * @return $this
     */
    public function setTerm($term)
    {
        $this->term = $term;

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
        $this->frequency++;

        return $this;
    }
}
