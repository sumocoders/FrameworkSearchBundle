<?php

namespace SumoCoders\FrameworkSearchBundle\EventListener;

use Doctrine\ORM\EntityManager;
use SumoCoders\FrameworkSearchBundle\Event\IndexUpdateEvent;
use SumoCoders\FrameworkSearchBundle\Event\IndexDeleteEvent;

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

    /**
     * The actual listener, will delete indexitems from the database
     *
     * @param IndexDeleteEvent $event
     */
    public function onIndexDelete(IndexDeleteEvent $event)
    {
        $query = $this->em->createQuery(
            'DELETE SumoCodersFrameworkSearchBundle:IndexItem i
             WHERE i.otherId = :id AND i.objectType = :objectType'
        )->setParameter('id', $event->getOtherId())
            ->setParameter('objectType', $event->getObjectType());
        $query->getResult();
    }
}
