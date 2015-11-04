<?php

namespace SumoCoders\FrameworkSearchBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class IndexDeleteEvent extends Event
{
    /**
     * @var string
     */
    protected $objectType;

    /**
     * @var string
     */
    protected $otherId;

    /**
     * @param string $objectType
     * @param string $otherId
     */
    public function __construct($objectType, $otherId)
    {
        $this->objectType = $objectType;
        $this->otherId = $otherId;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * @return string
     */
    public function getOtherId()
    {
        return $this->otherId;
    }
}
