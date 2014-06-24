<?php

namespace SumoCoders\FrameworkSearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndexItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository")
 */
class IndexItem
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="objectType", type="string", length=255)
     */
    protected $objectType;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="otherId", type="string", length=255)
     */
    protected $otherId;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="field", type="string", length=255)
     */
    protected $field;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    protected $value;

    /**
     * @param string $objectType
     * @param string $otherId
     * @param string $field
     * @param string $value
     */
    public function __construct($objectType, $otherId, $field, $value)
    {
        $this->setObjectType($objectType);
        $this->setOtherId($otherId);
        $this->setField($field);
        $this->setValue($value);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $objectType
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }

    /**
     * @return mixed
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set otherId
     *
     * @param string $otherId
     *
     * @return IndexItem
     */
    public function setOtherId($otherId)
    {
        $this->otherId = $otherId;

        return $this;
    }

    /**
     * Get otherId
     *
     * @return string
     */
    public function getOtherId()
    {
        return $this->otherId;
    }

    /**
     * Set field
     *
     * @param string $field
     *
     * @return IndexItem
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return IndexItem
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

