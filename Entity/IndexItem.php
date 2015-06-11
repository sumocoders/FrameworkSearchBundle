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
     * @param mixed  $otherId
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
     * @param mixed $otherId
     *
     * @return IndexItem
     */
    public function setOtherId($otherId)
    {
        $this->otherId = (string) $otherId;

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

    /**
     * Create an array of search index items based on the object
     *
     * @param string $class
     * @param string $id
     * @param array  $properties
     * @param mixed  $object
     * @return array
     */
    public static function createMultipleObjectsBasedOnProperties($class, $id, array $properties, $object)
    {
        $indexItems = array();

        foreach ($properties as $property) {
            $value = null;
            $method = array($object, 'get' . ucfirst($property));

            if (is_callable($method)) {
                $value = call_user_func($method);
            } elseif (isset($object->$property)) {
                $value = $object->$property;
            }

            if ($value !== null) {
                $indexItems[] = new IndexItem(
                    $class,
                    $id,
                    $property,
                    $value
                );
            }
        }

        return $indexItems;
    }
}
