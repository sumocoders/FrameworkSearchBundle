<?php

namespace SumoCoders\FrameworkSearchBundle\EventListener;

use Doctrine\ORM\EntityManager;
use SumoCoders\FrameworkSearchBundle\Event\IndexEvent;

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
     * @param IndexEvent $event
     */
    public function onIndexAdd(IndexEvent $event)
    {
        $objects = $event->getObjects();

        foreach ($objects as $indexItem) {
            $this->em->persist($indexItem);
        }

        $this->em->flush();
    }
}
