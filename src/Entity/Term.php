<?php

namespace Pucene\Bundle\DoctrineBundle\Entity;

class Term
{
    /**
     * @var string
     */
    private $term;

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
}
