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
        $this->setObjectType($objectType);
        $this->setOtherId($otherId);
    }

    /**
     * @param string $objectType
     */
    private function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * @param string $otherId
     */
    private function setOtherId($otherId)
    {
        $this->otherId = $otherId;
    }

    /**
     * @return string
     */
    public function getOtherId()
    {
        return $this->otherId;
    }
}
