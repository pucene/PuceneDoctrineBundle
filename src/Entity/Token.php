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
    protected $id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var int
     */
    protected $startOffset;

    /**
     * @var int
     */
    protected $endOffset;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var Field
     */
    protected $field;

    /**
     * Returns id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Returns startOffset.
     *
     * @return int
     */
    public function getStartOffset()
    {
        return $this->startOffset;
    }

    /**
     * Set startOffset.
     *
     * @param int $startOffset
     *
     * @return $this
     */
    public function setStartOffset($startOffset)
    {
        $this->startOffset = $startOffset;

        return $this;
    }

    /**
     * Returns endOffset.
     *
     * @return int
     */
    public function getEndOffset()
    {
        return $this->endOffset;
    }

    /**
     * Set endOffset.
     *
     * @param int $endOffset
     *
     * @return $this
     */
    public function setEndOffset($endOffset)
    {
        $this->endOffset = $endOffset;

        return $this;
    }

    /**
     * Returns type.
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
     * Returns position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

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
}

