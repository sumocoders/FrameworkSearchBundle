<?php

namespace SumoCoders\FrameworkSearchBundle\Event;

use SumoCoders\FrameworkSearchBundle\Entity\IndexItem;
use Symfony\Component\EventDispatcher\Event;

class IndexEvent extends Event
{
    /**
     * @var array
     */
    protected $objects = array();

    public function addObject(IndexItem $object)
    {
        $this->objects[] = $object;
    }

    /**
     * @param mixed $objects
     */
    public function setObjects(array $objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return mixed
     */
    public function getObjects()
    {
        return $this->objects;
    }
}
