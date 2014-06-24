<?php

namespace SumoCoders\FrameworkSearchBundle\EventListener;

use Doctrine\ORM\EntityManager;
use SumoCoders\FrameworkSearchBundle\Event\IndexUpdateEvent;

class IndexListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * The actual listener, will store the objects in the database
     *
     * @param IndexUpdateEvent $event
     */
    public function onIndexUpdate(IndexUpdateEvent $event)
    {
        $objects = $event->getObjects();

        foreach ($objects as $indexItem) {
            $this->em->merge($indexItem);
        }

        $this->em->flush();
    }
}
